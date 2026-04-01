<?php

namespace Tests\Feature;

use App\Jobs\GeneratePresentation;
use App\Models\Generation;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MvpEndToEndFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_flow_register_to_generate_workspace_and_export(): void
    {
        Queue::fake();

        $registration = $this->post('/register', [
            'name' => 'Deck User',
            'email' => 'deck-user@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $registration->assertRedirect(route('dashboard', absolute: false));

        $create = $this->post('/generations', [
            'source_text' => 'Create a short project summary deck.',
            'provider' => 'openai',
        ]);

        $create->assertRedirect(route('dashboard', absolute: false));
        Queue::assertPushed(GeneratePresentation::class, 1);

        /** @var Generation $generation */
        $generation = Generation::query()->latest()->firstOrFail();

        $generation->update([
            'status' => 'completed',
            'output_payload' => [
                'title' => 'Project Summary',
                'slides' => [
                    [
                        'title' => 'Overview',
                        'content' => 'Project goals and outcomes.',
                        'speaker_notes' => 'Open with impact metrics.',
                    ],
                ],
                'metadata' => [
                    'provider' => 'openai',
                    'slide_count' => 1,
                    'source_metadata' => [],
                ],
            ],
        ]);

        $workspace = $this->get(route('generations.show', $generation));
        $workspace
            ->assertOk()
               ->assertSee('Edit Slide')
               ->assertSee('Export');

        $this->mock(ExportService::class, function ($mock): void {
            $mock->shouldReceive('exportGenerationPdf')
                ->once()
                ->andReturn(response('pdf-bytes', 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="project-summary-1.pdf"',
                ]));
        });

        $export = $this->get(route('generations.export', $generation));
        $export
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
