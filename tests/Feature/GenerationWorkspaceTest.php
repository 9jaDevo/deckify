<?php

namespace Tests\Feature;

use App\Models\Generation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GenerationWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_view_workspace_page(): void
    {
        $user = User::factory()->create();
        $generation = $this->completedGenerationFor($user);

        $response = $this->actingAs($user)->get(route('generations.show', $generation));

        $response
            ->assertOk()
            ->assertSee('Edit Slide')
            ->assertSee('Back to All Decks');
    }

    public function test_non_owner_cannot_view_workspace(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $generation = $this->completedGenerationFor($owner);

        $this->actingAs($otherUser)
            ->get(route('generations.show', $generation))
            ->assertForbidden();
    }

    public function test_owner_can_update_active_slide_and_notes(): void
    {
        $user = User::factory()->create();
        $generation = $this->completedGenerationFor($user);

        $response = $this
            ->actingAs($user)
            ->patch(route('generations.slide.update', $generation), [
                'slide_index' => 0,
                'title' => 'Updated Strategy',
                'content' => 'Updated core content',
                'speaker_notes' => 'Updated notes',
            ]);

        $response->assertRedirect(route('generations.show', ['generation' => $generation, 'slide' => 0]));

        $slides = $generation->refresh()->output_payload['slides'];

        $this->assertSame('Updated Strategy', $slides[0]['title']);
        $this->assertSame('Updated core content', $slides[0]['content']);
        $this->assertSame('Updated notes', $slides[0]['speaker_notes']);
    }

    public function test_prompt_refinement_updates_active_slide(): void
    {
        config()->set('services.openai.api_key', 'test-openai-key');
        config()->set('services.openai.base_url', 'https://api.openai.com/v1');

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'title' => 'Refined deck',
                                'slides' => [
                                    [
                                        'title' => 'Refined slide',
                                        'content' => 'Refined content body',
                                        'speaker_notes' => 'Refined note',
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
        $generation = $this->completedGenerationFor($user);

        $response = $this
            ->actingAs($user)
            ->patch(route('generations.slide.refine', $generation), [
                'slide_index' => 0,
                'prompt' => 'Make this clearer and shorter',
            ]);

        $response->assertRedirect(route('generations.show', ['generation' => $generation, 'slide' => 0]));

        $slides = $generation->refresh()->output_payload['slides'];
        $this->assertSame('Refined slide', $slides[0]['title']);
        $this->assertSame('Refined content body', $slides[0]['content']);
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
                        'title' => 'Original slide',
                        'content' => 'Original content',
                        'speaker_notes' => 'Original notes',
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
