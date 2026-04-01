<?php

namespace App\Services\AI;

use App\Services\AI\Exceptions\AiProviderException;
use App\Services\AI\Exceptions\NormalizationException;
use Throwable;

class ProviderErrorMapper
{
    /**
     * @return array{code: string, message: string}
     */
    public function map(Throwable $exception): array
    {
        if ($exception instanceof AiProviderException) {
            return [
                'code' => $exception->errorCode,
                'message' => $exception->userMessage,
            ];
        }

        if ($exception instanceof NormalizationException) {
            return [
                'code' => 'normalization_error',
                'message' => 'The AI response format was invalid. Please try again.',
            ];
        }

        return [
            'code' => 'unexpected_error',
            'message' => 'Generation failed unexpectedly. Please try again.',
        ];
    }
}
