<?php

namespace Tests\Feature;

use App\Jobs\GeneratePresentation;
use App\Models\Generation;
use App\Models\User;
use App\Services\AI\DocumentTextExtractor;
use App\Services\AI\GenerationService;
use App\Services\AI\ProviderErrorMapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Throwable;

class GeneratePresentationJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_marks_generation_completed_on_provider_success(): void
    {
        config()->set('services.openai.api_key', 'test-key');
        config()->set('services.openai.base_url', 'https://api.openai.com/v1');

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'title' => 'Growth Plan',
                                'slides' => [
                                    [
                                        'title' => 'Summary',
                                        'content' => 'Revenue grew by 28%.',
                                        'speaker_notes' => 'Highlight quarterly trend.',
                                    ],
                                ],
                                'metadata' => ['tone' => 'concise'],
                            ], JSON_THROW_ON_ERROR),
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->create();

        $generation = Generation::create([
            'user_id' => $user->id,
            'title' => 'Draft',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'draft',
            'input_text' => 'Turn this into a business deck.',
        ]);

        $job = new GeneratePresentation($generation->id);
        $job->handle(
            app(GenerationService::class),
            app(DocumentTextExtractor::class),
            app(ProviderErrorMapper::class),
        );

        $generation->refresh();

        $this->assertSame('completed', $generation->status);
        $this->assertIsArray($generation->output_payload);
        $this->assertSame('Summary', $generation->output_payload['slides'][0]['title']);
        $this->assertSame('Highlight quarterly trend.', $generation->speaker_notes);
    }

    public function test_job_marks_generation_failed_on_provider_error(): void
    {
        config()->set('services.openai.api_key', '');

        $user = User::factory()->create();

        $generation = Generation::create([
            'user_id' => $user->id,
            'title' => 'Draft',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'draft',
            'input_text' => 'Turn this into a business deck.',
        ]);

        $job = new GeneratePresentation($generation->id);

        try {
            $job->handle(
                app(GenerationService::class),
                app(DocumentTextExtractor::class),
                app(ProviderErrorMapper::class),
            );

            $this->fail('Expected job to throw on provider error.');
        } catch (Throwable) {
            $generation->refresh();

            $this->assertSame('failed', $generation->status);
            $this->assertSame('OpenAI is not configured. Please contact support.', $generation->failed_reason);
        }
    }
}
