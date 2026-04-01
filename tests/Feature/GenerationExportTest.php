<?php

namespace Tests\Feature;

use App\Models\Generation;
use App\Models\User;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerationExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_export_completed_generation(): void
    {
        $user = User::factory()->create();
        $generation = $this->completedGenerationFor($user);

        $this->mock(ExportService::class, function ($mock): void {
            $mock->shouldReceive('exportGenerationPdf')
                ->once()
                ->andReturn(response('pdf-bytes', 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="workspace-deck-1.pdf"',
                ]));
        });

        $response = $this
            ->actingAs($user)
            ->get(route('generations.export', $generation));

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_non_owner_cannot_export_generation(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $generation = $this->completedGenerationFor($owner);

        $this->actingAs($otherUser)
            ->get(route('generations.export', $generation))
            ->assertForbidden();
    }

    public function test_export_rejects_non_completed_generation(): void
    {
        $user = User::factory()->create();

        $generation = Generation::create([
            'user_id' => $user->id,
            'title' => 'Draft deck',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'draft',
            'input_text' => 'Sample input',
        ]);

        $response = $this
            ->actingAs($user)
            ->from(route('generations.show', $generation))
            ->get(route('generations.export', $generation));

        $response
            ->assertRedirect(route('generations.show', ['generation' => $generation]))
            ->assertSessionHas('status', 'Only completed generations with slides can be exported.');
    }

    /**
     * @return Generation
     */
    private function completedGenerationFor(User $user): Generation
    {
        return Generation::create([
            'user_id' => $user->id,
            'title' => 'Workspace Deck',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'completed',
            'input_text' => 'Sample input',
            'output_payload' => [
                'title' => 'Workspace Deck',
                'slides' => [
                    [
                        'title' => 'Slide one',
                        'content' => 'Slide body',
                        'speaker_notes' => 'Slide notes',
                    ],
                ],
                'metadata' => [
                    'provider' => 'openai',
                    'slide_count' => 1,
                    'source_metadata' => [],
                ],
            ],
        ]);
    }
}
