<?php

namespace Tests\Feature;

use App\Jobs\GeneratePresentation;
use App\Models\Generation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class GenerationIntakeValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_is_redirected_from_generation_submit(): void
    {
        $response = $this->post('/generations', [
            'source_text' => 'Content',
            'provider' => 'openai',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_generation_requires_text_or_docx(): void
    {
        Queue::fake();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/dashboard')
            ->post('/generations', [
                'source_text' => '   ',
                'provider' => 'openai',
            ]);

        $response
            ->assertRedirect('/dashboard')
            ->assertSessionHasErrors(['source_text']);

        Queue::assertNothingPushed();
    }

    public function test_generation_requires_provider_selection(): void
    {
        Queue::fake();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/dashboard')
            ->post('/generations', [
                'source_text' => 'A valid text input for generation.',
            ]);

        $response
            ->assertRedirect('/dashboard')
            ->assertSessionHasErrors(['provider'])
            ->assertSessionHasInput('source_text', 'A valid text input for generation.');

        Queue::assertNothingPushed();
    }

    public function test_generation_accepts_valid_docx_upload(): void
    {
        Queue::fake();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/generations', [
                'provider' => 'grok',
                'source_file' => UploadedFile::fake()->create('deck.docx', 120),
            ]);

        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('generations', [
            'user_id' => $user->id,
            'source_type' => 'docx',
            'provider' => 'grok',
        ]);

        Queue::assertPushed(GeneratePresentation::class, 1);
    }

    public function test_generation_rejects_invalid_file_type(): void
    {
        Queue::fake();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/dashboard')
            ->post('/generations', [
                'provider' => 'openai',
                'source_file' => UploadedFile::fake()->create('slides.pdf', 200),
            ]);

        $response
            ->assertRedirect('/dashboard')
            ->assertSessionHasErrors(['source_file']);

        Queue::assertNothingPushed();
    }

    public function test_generation_rejects_oversized_docx(): void
    {
        Queue::fake();
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/dashboard')
            ->post('/generations', [
                'provider' => 'openai',
                'source_file' => UploadedFile::fake()->create('huge.docx', 10241),
            ]);

        $response
            ->assertRedirect('/dashboard')
            ->assertSessionHasErrors(['source_file']);

        Queue::assertNothingPushed();
    }

    public function test_dashboard_lists_generation_metadata_fields(): void
    {
        $user = User::factory()->create();

        Generation::create([
            'user_id' => $user->id,
            'title' => 'Quarterly Plan',
            'source_type' => 'docx',
            'provider' => 'openai',
            'status' => 'draft',
            'input_text' => null,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response
            ->assertOk()
            ->assertSee('Quarterly Plan')
               ->assertSee('Quarterly Plan')
               ->assertSee('Drafting');
    }
}
