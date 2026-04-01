<?php

namespace App\Services\AI\Exceptions;

use RuntimeException;

class AiProviderException extends RuntimeException
{
    public function __construct(
        public readonly string $userMessage,
        public readonly string $errorCode = 'provider_error',
    ) {
        parent::__construct($userMessage);
    }
}
