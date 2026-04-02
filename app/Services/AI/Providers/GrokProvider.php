<?php

namespace App\Services\AI\Providers;

use App\Services\AI\Contracts\AiProviderInterface;
use App\Services\AI\Exceptions\AiProviderException;
use App\Services\AI\PresentationNormalizer;
use Illuminate\Support\Facades\Http;

class GrokProvider implements AiProviderInterface
{
    public function __construct(private readonly PresentationNormalizer $normalizer)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function generatePresentation(string $input): array
    {
        $apiKey = (string) config('services.grok.api_key');
        $model = (string) config('services.grok.model', 'grok-2-latest');
        $baseUrl = rtrim((string) config('services.grok.base_url', 'https://api.x.ai/v1'), '/');

        if ($apiKey === '') {
            throw new AiProviderException('Grok is not configured. Please contact support.', 'provider_not_configured');
        }

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->asJson()
            ->timeout(120)
            ->retry(2, 500)
            ->post($baseUrl.'/chat/completions', [
                'model' => $model,
                'temperature' => 0.2,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->systemPrompt(),
                    ],
                    [
                        'role' => 'user',
                        'content' => $input,
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw $this->responseException($response->status());
        }

        $content = data_get($response->json(), 'choices.0.message.content');

        if (! is_string($content) || trim($content) === '') {
            throw new AiProviderException('Grok returned an empty response.', 'empty_response');
        }

        return $this->normalizer->normalize($content, 'grok');
    }

    private function systemPrompt(): string
    {
        return 'You are Deckify AI. Return only valid JSON with this schema: '
            .'{"title":"string","slides":[{"title":"string","content":"string","speaker_notes":"string"}],"metadata":{"tone":"string"}}.'
            .' Do not include markdown fences.';
    }

    private function responseException(int $status): AiProviderException
    {
        return match ($status) {
            401, 403 => new AiProviderException('Grok authentication failed.', 'auth_error'),
            429 => new AiProviderException('Grok is rate-limited right now. Please retry shortly.', 'rate_limited'),
            default => new AiProviderException('Grok could not process this request.', 'provider_request_failed'),
        };
    }
}
