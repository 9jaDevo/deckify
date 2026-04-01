<?php

namespace Tests\Unit\Services\AI;

use App\Services\AI\Exceptions\NormalizationException;
use App\Services\AI\PresentationNormalizer;
use Tests\TestCase;

class PresentationNormalizerTest extends TestCase
{
    public function test_normalizer_returns_internal_schema(): void
    {
        $normalizer = new PresentationNormalizer;

        $result = $normalizer->normalize(json_encode([
            'title' => 'Go To Market',
            'slides' => [
                [
                    'title' => 'Opportunity',
                    'content' => 'Fast-growing segment.',
                    'speaker_notes' => 'Mention CAGR.',
                ],
            ],
            'metadata' => ['tone' => 'executive'],
        ], JSON_THROW_ON_ERROR), 'openai');

        $this->assertSame('Go To Market', $result['title']);
        $this->assertSame(1, $result['metadata']['slide_count']);
        $this->assertSame('Opportunity', $result['slides'][0]['title']);
    }

    public function test_normalizer_throws_on_missing_slides(): void
    {
        $this->expectException(NormalizationException::class);

        $normalizer = new PresentationNormalizer;
        $normalizer->normalize('{"title":"Bad payload"}', 'openai');
    }
}
