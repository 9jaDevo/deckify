<?php

namespace App\Services\AI;

use App\Models\Generation;
use App\Services\AI\Exceptions\AiProviderException;

class SlideRefinementService
{
    public function __construct(private readonly GenerationService $generationService)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function refineSlide(Generation $generation, int $slideIndex, string $prompt): array
    {
        $payload = is_array($generation->output_payload) ? $generation->output_payload : [];
        $slides = $payload['slides'] ?? [];

        if (! is_array($slides) || ! isset($slides[$slideIndex]) || ! is_array($slides[$slideIndex])) {
            throw new AiProviderException('Selected slide could not be refined.', 'invalid_slide_index');
        }

        $activeSlide = $slides[$slideIndex];

        $input = $this->buildPromptInput($generation, $activeSlide, $prompt);
        $result = $this->generationService->generate($generation->provider, $input);

        $refinedSlide = $result['slides'][0] ?? null;

        if (! is_array($refinedSlide)) {
            throw new AiProviderException('AI refinement did not return a valid slide.', 'invalid_refinement_response');
        }

        $slides[$slideIndex] = [
            'title' => trim((string) ($refinedSlide['title'] ?? ($activeSlide['title'] ?? 'Untitled Slide'))),
            'content' => trim((string) ($refinedSlide['content'] ?? ($activeSlide['content'] ?? ''))),
            'speaker_notes' => trim((string) ($refinedSlide['speaker_notes'] ?? ($activeSlide['speaker_notes'] ?? ''))),
        ];

        $payload['slides'] = $slides;
        $payload['metadata'] = array_merge(
            is_array($payload['metadata'] ?? null) ? $payload['metadata'] : [],
            ['slide_count' => count($slides)]
        );

        return $payload;
    }

    /**
     * @param array<string, mixed> $slide
     */
    private function buildPromptInput(Generation $generation, array $slide, string $prompt): string
    {
        $slideJson = json_encode([
            'title' => (string) ($slide['title'] ?? ''),
            'content' => (string) ($slide['content'] ?? ''),
            'speaker_notes' => (string) ($slide['speaker_notes'] ?? ''),
        ], JSON_PRETTY_PRINT);

        return "Refine the slide below based on user instruction. Return only JSON using Deckify schema with exactly one slide in slides array.\n"
            ."Deck title: ".($generation->title ?? 'Generated Deck')."\n"
            ."User instruction: {$prompt}\n"
            ."Current slide:\n{$slideJson}";
    }
}
