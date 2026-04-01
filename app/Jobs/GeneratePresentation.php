<?php

namespace App\Jobs;

use App\Models\Generation;
use App\Services\AI\DocumentTextExtractor;
use App\Services\AI\GenerationService;
use App\Services\AI\ProviderErrorMapper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class GeneratePresentation implements ShouldQueue
{
    use Queueable;

    /**
     * @var list<int>
     */
    public array $backoff = [10, 30, 60];

    public int $tries = 3;

    public function __construct(public int $generationId)
    {
    }

    public function handle(
        GenerationService $generationService,
        DocumentTextExtractor $documentTextExtractor,
        ProviderErrorMapper $errorMapper,
    ): void {
        $generation = Generation::query()->find($this->generationId);

        if (! $generation) {
            return;
        }

        $generation->update([
            'status' => 'processing',
            'failed_reason' => null,
        ]);

        try {
            $input = $this->resolveInput($generation, $documentTextExtractor);
            $result = $generationService->generate($generation->provider, $input);

            $speakerNotes = collect($result['slides'] ?? [])
                ->pluck('speaker_notes')
                ->filter(fn (mixed $value): bool => is_string($value) && trim($value) !== '')
                ->implode("\n\n");

            $generation->update([
                'status' => 'completed',
                'output_payload' => $result,
                'speaker_notes' => $speakerNotes !== '' ? $speakerNotes : null,
                'failed_reason' => null,
            ]);
        } catch (Throwable $exception) {
            $mapped = $errorMapper->map($exception);

            $generation->update([
                'status' => 'failed',
                'failed_reason' => $mapped['message'],
            ]);

            Log::warning('Generation processing failed', [
                'generation_id' => $generation->id,
                'provider' => $generation->provider,
                'error_code' => $mapped['code'],
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    private function resolveInput(Generation $generation, DocumentTextExtractor $documentTextExtractor): string
    {
        if ($generation->source_type === 'text') {
            return trim((string) $generation->input_text);
        }

        return $documentTextExtractor->extract($generation->source_file_path);
    }
}
