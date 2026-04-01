<?php

namespace App\Services\AI;

use App\Jobs\GeneratePresentation;
use App\Models\Generation;
use App\Services\AI\Contracts\AiProviderInterface;
use App\Services\AI\Exceptions\AiProviderException;
use App\Services\AI\Providers\GrokProvider;
use App\Services\AI\Providers\OpenAiProvider;

class GenerationService
{
    public function __construct(
        private readonly OpenAiProvider $openAiProvider,
        private readonly GrokProvider $grokProvider,
    ) {
    }

    public function dispatch(Generation $generation): void
    {
        GeneratePresentation::dispatch($generation->id);
    }

    /**
     * @return array<string, mixed>
     */
    public function generate(string $provider, string $input): array
    {
        return $this->resolveProvider($provider)->generatePresentation($input);
    }

    private function resolveProvider(string $provider): AiProviderInterface
    {
        return match ($provider) {
            'openai' => $this->openAiProvider,
            'grok' => $this->grokProvider,
            default => throw new AiProviderException('Unsupported AI provider selected.', 'unsupported_provider'),
        };
    }
}
