<?php

namespace Tests\Feature;

use App\Jobs\GeneratePresentation;
use App\Models\Generation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class GenerationPlanLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_plan_limit_is_enforced(): void
    {
        config()->set('deckify.plan_limits.free', 1);

        Queue::fake();
        $user = User::factory()->create(['plan' => 'free']);

        Generation::create([
            'user_id' => $user->id,
            'title' => 'Existing',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'completed',
            'input_text' => 'Existing generation',
        ]);

        $response = $this
            ->actingAs($user)
            ->from('/dashboard')
            ->post('/generations', [
                'source_text' => 'Try another generation',
                'provider' => 'openai',
            ]);

        $response
            ->assertRedirect('/dashboard')
            ->assertSessionHasErrors(['plan_limit']);

        Queue::assertNothingPushed();
    }

    public function test_pro_plan_gets_higher_limit(): void
    {
        config()->set('deckify.plan_limits.pro', 2);

        Queue::fake();
        $user = User::factory()->create(['plan' => 'pro']);

        Generation::create([
            'user_id' => $user->id,
            'title' => 'Existing 1',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'completed',
            'input_text' => 'Existing generation',
        ]);

        $response = $this
            ->actingAs($user)
            ->post('/generations', [
                'source_text' => 'Allowed second generation',
                'provider' => 'openai',
            ]);

        $generation = \App\Models\Generation::query()->latest('id')->firstOrFail();
        $response->assertRedirect(route('generations.progress', $generation));
        Queue::assertPushed(GeneratePresentation::class, 1);
    }

    public function test_team_plan_gets_highest_limit(): void
    {
        config()->set('deckify.plan_limits.team', 3);

        Queue::fake();
        $user = User::factory()->create(['plan' => 'team']);

        for ($i = 0; $i < 2; $i++) {
            Generation::create([
                'user_id' => $user->id,
                'title' => 'Existing '.$i,
                'source_type' => 'text',
                'provider' => 'openai',
                'status' => 'completed',
                'input_text' => 'Existing generation',
            ]);
        }

        $response = $this
            ->actingAs($user)
            ->post('/generations', [
                'source_text' => 'Allowed third generation',
                'provider' => 'openai',
            ]);

        $generation = \App\Models\Generation::query()->latest('id')->firstOrFail();
        $response->assertRedirect(route('generations.progress', $generation));
        Queue::assertPushed(GeneratePresentation::class, 1);
    }

    public function test_dashboard_shows_usage_indicator(): void
    {
        config()->set('deckify.plan_limits.free', 5);

        $user = User::factory()->create(['plan' => 'free']);

        Generation::create([
            'user_id' => $user->id,
            'title' => 'Existing',
            'source_type' => 'text',
            'provider' => 'openai',
            'status' => 'completed',
            'input_text' => 'Existing generation',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response
            ->assertOk()
               ->assertSee('Free Plan')
               ->assertSeeText('1/5 this month');
    }
}
