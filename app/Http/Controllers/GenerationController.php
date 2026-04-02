<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefineGenerationSlideRequest;
use App\Http\Requests\StoreGenerationRequest;
use App\Http\Requests\UpdateGenerationSlideRequest;
use App\Models\Generation;
use App\Services\AI\ProviderErrorMapper;
use App\Services\AI\GenerationService;
use App\Services\AI\SlideRefinementService;
use App\Services\ExportService;
use App\Services\PlanLimitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class GenerationController extends Controller
{
    public function index(Request $request): View
    {
        $usageService = app(PlanLimitService::class);
        $user = $request->user();

        $generations = $request->user()
            ->generations()
            ->latest()
            ->paginate(10);

        return view('dashboard', [
            'generations' => $generations,
            'planName' => strtoupper((string) $user->plan),
            'usageCount' => $usageService->usageForCurrentMonth($user),
            'usageLimit' => $usageService->limitFor($user),
            'remainingCount' => $usageService->remainingForCurrentMonth($user),
            'isLimitReached' => $usageService->hasReachedLimit($user),
        ]);
    }

    public function store(
        StoreGenerationRequest $request,
        GenerationService $generationService,
        PlanLimitService $planLimitService,
    ): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        if ($planLimitService->hasReachedLimit($user)) {
            return back()
                ->withErrors([
                    'plan_limit' => sprintf(
                        'You reached your %s plan monthly generation limit (%d). Upgrade your plan or try again next month.',
                        strtoupper((string) $user->plan),
                        $planLimitService->limitFor($user),
                    ),
                ])
                ->withInput();
        }

        $sourceType = $request->hasFile('source_file') ? 'docx' : 'text';
        $sourceFilePath = $request->hasFile('source_file')
            ? $request->file('source_file')->store('generation-sources', 'local')
            : null;

        $title = $sourceType === 'docx'
            ? pathinfo($request->file('source_file')->getClientOriginalName(), PATHINFO_FILENAME)
            : str((string) $validated['source_text'])->limit(50)->toString();

        $generation = Generation::create([
            'user_id' => $user->id,
            'title' => $title ?: 'Untitled generation',
            'source_type' => $sourceType,
            'source_file_path' => $sourceFilePath,
            'provider' => $validated['provider'],
            'status' => 'draft',
            'input_text' => $validated['source_text'] ?? null,
        ]);

        try {
            $generationService->dispatch($generation);
        } catch (Throwable $e) {
            $generation->refresh();

            $reason = filled($generation->failed_reason)
                ? $generation->failed_reason
                : 'Generation failed. Please try again.';

            if ($generation->status !== 'failed') {
                $generation->update([
                    'status' => 'failed',
                    'failed_reason' => $reason,
                ]);
            }

            return redirect()
                ->route('dashboard')
                ->with('status', $reason)
                ->with('status_type', 'error');
        }

        $generation->refresh();

        if ($generation->status === 'failed') {
            return redirect()
                ->route('dashboard')
                ->with('status', $generation->failed_reason ?? 'Generation failed unexpectedly.')
                ->with('status_type', 'error');
        }

        return redirect()
            ->route('dashboard')
            ->with('status', 'Slides generated successfully!')
            ->with('status_type', 'success');
    }

    public function show(Request $request, Generation $generation): View
    {
        $this->ensureOwner($request, $generation);

        $slides = $this->slides($generation);
        $slideIndex = (int) $request->query('slide', 0);
        $activeSlide = $slides[$slideIndex] ?? null;

        if ($activeSlide === null && $slides !== []) {
            $slideIndex = 0;
            $activeSlide = $slides[0];
        }

        return view('generations.show', [
            'generation' => $generation,
            'slides' => $slides,
            'slideIndex' => $slideIndex,
            'activeSlide' => is_array($activeSlide) ? $activeSlide : null,
        ]);
    }

    public function updateSlide(UpdateGenerationSlideRequest $request, Generation $generation): RedirectResponse
    {
        $this->ensureOwner($request, $generation);

        $validated = $request->validated();
        $slideIndex = (int) $validated['slide_index'];

        $payload = is_array($generation->output_payload) ? $generation->output_payload : [];
        $slides = $payload['slides'] ?? [];

        if (! is_array($slides) || ! isset($slides[$slideIndex]) || ! is_array($slides[$slideIndex])) {
            return back()->with('status', 'Selected slide was not found.');
        }

        $slides[$slideIndex]['title'] = trim((string) ($validated['title'] ?? $slides[$slideIndex]['title'] ?? 'Untitled Slide'));
        $slides[$slideIndex]['content'] = trim((string) ($validated['content'] ?? $slides[$slideIndex]['content'] ?? ''));
        $slides[$slideIndex]['speaker_notes'] = trim((string) ($validated['speaker_notes'] ?? $slides[$slideIndex]['speaker_notes'] ?? ''));

        $payload['slides'] = $slides;
        $payload['metadata'] = array_merge(
            is_array($payload['metadata'] ?? null) ? $payload['metadata'] : [],
            ['slide_count' => count($slides)]
        );

        $generation->update([
            'output_payload' => $payload,
            'speaker_notes' => $this->aggregateSpeakerNotes($slides),
        ]);

        return redirect()
            ->route('generations.show', ['generation' => $generation, 'slide' => $slideIndex])
            ->with('status', 'Slide updated successfully.')
            ->with('status_type', 'success');
    }

    public function refineSlide(
        RefineGenerationSlideRequest $request,
        Generation $generation,
        SlideRefinementService $slideRefinementService,
        ProviderErrorMapper $errorMapper,
    ): RedirectResponse {
        $this->ensureOwner($request, $generation);

        $validated = $request->validated();
        $slideIndex = (int) $validated['slide_index'];

        try {
            $payload = $slideRefinementService->refineSlide($generation, $slideIndex, (string) $validated['prompt']);

            $generation->update([
                'output_payload' => $payload,
                'speaker_notes' => $this->aggregateSpeakerNotes($payload['slides'] ?? []),
            ]);

            return redirect()
                ->route('generations.show', ['generation' => $generation, 'slide' => $slideIndex])
                ->with('status', 'AI refinement applied to the active slide.')
                ->with('status_type', 'success');
        } catch (Throwable $exception) {
            $mapped = $errorMapper->map($exception);

            return redirect()
                ->route('generations.show', ['generation' => $generation, 'slide' => $slideIndex])
                ->with('status', $mapped['message'])
                ->with('status_type', 'error');
        }
    }

    public function export(Request $request, Generation $generation, ExportService $exportService)
    {
        $this->ensureOwner($request, $generation);

        if ($generation->status !== 'completed' || $this->slides($generation) === []) {
            return redirect()
                ->route('generations.show', ['generation' => $generation])
                ->with('status', 'Only completed generations with slides can be exported.')
                ->with('status_type', 'error');
        }

        return $exportService->exportGenerationPdf($generation);
    }

    private function ensureOwner(Request $request, Generation $generation): void
    {
        abort_if((int) $generation->user_id !== (int) $request->user()->id, 403);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function slides(Generation $generation): array
    {
        $payload = is_array($generation->output_payload) ? $generation->output_payload : [];
        $slides = $payload['slides'] ?? [];

        return is_array($slides) ? array_values(array_filter($slides, 'is_array')) : [];
    }

    /**
     * @param mixed $slides
     */
    private function aggregateSpeakerNotes(mixed $slides): ?string
    {
        if (! is_array($slides)) {
            return null;
        }

        $notes = collect($slides)
            ->pluck('speaker_notes')
            ->filter(fn (mixed $value): bool => is_string($value) && trim($value) !== '')
            ->implode("\n\n");

        return $notes !== '' ? $notes : null;
    }
}
