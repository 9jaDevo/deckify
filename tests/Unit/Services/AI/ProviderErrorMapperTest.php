<?php

namespace Tests\Unit\Services\AI;

use App\Services\AI\Exceptions\AiProviderException;
use App\Services\AI\Exceptions\NormalizationException;
use App\Services\AI\ProviderErrorMapper;
use Tests\TestCase;

class ProviderErrorMapperTest extends TestCase
{
    public function test_mapper_handles_provider_exception(): void
    {
        $mapper = new ProviderErrorMapper;
        $mapped = $mapper->map(new AiProviderException('Auth failed', 'auth_error'));

        $this->assertSame('auth_error', $mapped['code']);
        $this->assertSame('Auth failed', $mapped['message']);
    }

    public function test_mapper_handles_normalization_exception(): void
    {
        $mapper = new ProviderErrorMapper;
        $mapped = $mapper->map(new NormalizationException('Bad payload'));

        $this->assertSame('normalization_error', $mapped['code']);
        $this->assertSame('The AI response format was invalid. Please try again.', $mapped['message']);
    }
}
