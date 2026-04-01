<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenerationRequest;
use App\Models\Generation;
use App\Services\AI\GenerationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class GenerationController extends Controller
{
    public function index(Request $request): View
    {
        $generations = $request->user()
            ->generations()
            ->latest()
            ->paginate(10);

        return view('dashboard', [
            'generations' => $generations,
        ]);
    }

    public function store(StoreGenerationRequest $request, GenerationService $generationService): RedirectResponse
    {
        $validated = $request->validated();

        $sourceType = $request->hasFile('source_file') ? 'docx' : 'text';
        $sourceFilePath = $request->hasFile('source_file')
            ? $request->file('source_file')->store('generation-sources', 'local')
            : null;

        $title = $sourceType === 'docx'
            ? pathinfo($request->file('source_file')->getClientOriginalName(), PATHINFO_FILENAME)
            : str((string) $validated['source_text'])->limit(50)->toString();

        $generation = Generation::create([
            'user_id' => $request->user()->id,
            'title' => $title ?: 'Untitled generation',
            'source_type' => $sourceType,
            'source_file_path' => $sourceFilePath,
            'provider' => $validated['provider'],
            'status' => 'draft',
            'input_text' => $validated['source_text'] ?? null,
        ]);

        try {
            $generationService->dispatch($generation);
        } catch (Throwable) {
            $generation->update([
                'status' => 'failed',
                'failed_reason' => 'Could not queue generation. Please try again.',
            ]);

            return redirect()
                ->route('dashboard')
                ->with('status', 'Generation could not be queued. Please retry.');
        }

        return redirect()
            ->route('dashboard')
            ->with('status', 'Generation queued. AI processing has started.');
    }
}
