<?php

namespace Tests\Feature;

use App\Jobs\GeneratePresentation;
use App\Models\Generation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class GenerationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_queue_generation(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/generations', [
                'source_text' => 'Create slides about market expansion strategy.',
                'provider' => 'openai',
            ]);

        $response
            ->assertRedirect(route('dashboard', absolute: false))
            ->assertSessionHas('status', 'Generation queued. AI processing has started.');

        $this->assertDatabaseHas('generations', [
            'user_id' => $user->id,
            'provider' => 'openai',
            'status' => 'draft',
            'source_type' => 'text',
        ]);

        Queue::assertPushed(GeneratePresentation::class, 1);
    }

    public function test_dashboard_shows_failed_reason_when_generation_fails(): void
    {
        $user = User::factory()->create();

        Generation::create([
            'user_id' => $user->id,
            'title' => 'Failed deck',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'failed',
            'input_text' => 'Sample',
            'failed_reason' => 'OpenAI authentication failed.',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response
            ->assertOk()
            ->assertSee('OpenAI authentication failed.');
    }
}
