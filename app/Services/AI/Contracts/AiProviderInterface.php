<?php

namespace App\Services\AI\Contracts;

interface AiProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function generatePresentation(string $input): array;
}
