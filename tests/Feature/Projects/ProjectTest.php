<?php

namespace Tests\Feature\Projects;

use App\Models\Project;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = auth('api')->login($this->user);
    }

    /** @test */
    public function can_get_list_of_published_projects()
    {
        Project::factory()->create(['status' => 'published', 'author_id' => $this->user->id]);
        Project::factory()->create(['status' => 'draft', 'author_id' => $this->user->id]);

        $response = $this->getJson('/api/projects');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    /** @test */
    public function can_get_single_published_project()
    {
        $project = Project::factory()->create([
            'status' => 'published',
            'author_id' => $this->user->id,
        ]);

        $response = $this->getJson("/api/projects/{$project->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'title' => $project->title,
                 ]);
    }

    /** @test */
    public function cannot_get_draft_project_without_auth()
    {
        $project = Project::factory()->create([
            'status' => 'draft',
            'author_id' => $this->user->id,
        ]);

        $response = $this->getJson("/api/projects/{$project->id}");

        $response->assertStatus(404);
    }

    /** @test */
    public function cannot_create_project_without_auth()
    {
        auth('api')->logout();

        $project = Project::factory()->make()->toArray();

        $response = $this->postJson('/api/projects', $project);

        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_create_project()
    {
        $technology = Technology::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            ])->postJson('/api/projects', [
            'title' => 'Test Project',
            'slug' => 'test-project',
            'description' => 'Description de test avec plus de 10 caractères',
            'status' => 'draft',
            'type' => 'frontend',
            'date_realisation' => '2025-01-15',
            'order' => 1,
            'technologies' => [$technology->id],
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'title' => 'Test Project',
                 ]);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
        ]);
    }

    /** @test */
    public function project_creation_validates_required_fields()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/projects', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'title',
                     'description',
                     'status',
                     'type',
                     'date_realisation',
                     'order',
                 ]);
    }

    /** @test */
    public function authenticated_user_can_update_project()
    {
        $project = Project::factory()->create([
            'author_id' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            ])->putJson("/api/projects/{$project->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_project()
    {
        $project = Project::factory()->create([
            'author_id' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('projects', [
            'id' => $project->id,
        ]);
    }
}
