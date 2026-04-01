<?php

namespace App\Services\AI;

use App\Services\AI\Exceptions\NormalizationException;

class PresentationNormalizer
{
    /**
     * @return array<string, mixed>
     */
    public function normalize(string $content, string $provider): array
    {
        $decoded = $this->decodeJsonContent($content);

        if (! is_array($decoded)) {
            throw new NormalizationException('AI response did not return a valid JSON object.');
        }

        $slides = $decoded['slides'] ?? null;

        if (! is_array($slides) || $slides === []) {
            throw new NormalizationException('AI response did not include any slides.');
        }

        $normalizedSlides = [];

        foreach ($slides as $slide) {
            if (! is_array($slide)) {
                continue;
            }

            $title = trim((string) ($slide['title'] ?? ''));
            $contentText = trim((string) ($slide['content'] ?? ''));
            $speakerNotes = trim((string) ($slide['speaker_notes'] ?? ''));

            if ($title === '' && $contentText === '' && $speakerNotes === '') {
                continue;
            }

            $normalizedSlides[] = [
                'title' => $title !== '' ? $title : 'Untitled Slide',
                'content' => $contentText,
                'speaker_notes' => $speakerNotes,
            ];
        }

        if ($normalizedSlides === []) {
            throw new NormalizationException('AI response contained only empty slides.');
        }

        $metadata = $decoded['metadata'] ?? [];

        return [
            'title' => trim((string) ($decoded['title'] ?? 'Generated Deck')),
            'slides' => $normalizedSlides,
            'metadata' => [
                'provider' => $provider,
                'slide_count' => count($normalizedSlides),
                'source_metadata' => is_array($metadata) ? $metadata : [],
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function decodeJsonContent(string $content): ?array
    {
        $trimmed = trim($content);

        if (str_starts_with($trimmed, '```')) {
            $trimmed = preg_replace('/^```(?:json)?\s*/', '', $trimmed) ?? $trimmed;
            $trimmed = preg_replace('/\s*```$/', '', $trimmed) ?? $trimmed;
            $trimmed = trim($trimmed);
        }

        /** @var array<string, mixed>|null $decoded */
        $decoded = json_decode($trimmed, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }
}
