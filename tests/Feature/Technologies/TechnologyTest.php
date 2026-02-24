<?php

namespace Tests\Feature\Technologies;

use App\Models\Technology;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TechnologyTest extends TestCase
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
    public function can_get_list_of_technologies()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Technology::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Technology::factory()->count(5)->create();

        $response = $this->getJson('/api/technologies');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function cannot_create_technology_without_auth()
    {
        auth('api')->logout();

        $response = $this->postJson('/api/technologies', [
            'name' => 'React',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_create_technology()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/technologies', [
            'name' => 'Vue.js',
            'type' => 'frontend',
            'color' => '#42b883',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => 'Vue.js',
                 ]);

        $this->assertDatabaseHas('technologies', [
            'name' => 'Vue.js',
        ]);
    }
}