<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = auth('api')->login($this->user);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Identifiants incorrects',
            ]);
    }

    /** @test */
    public function login_is_rate_limited_after_five_attempts()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/login', [
                'email' => $this->user->email,
                'password' => 'wrong',
            ]);
        }

        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'wrong',
        ]);

        $response->assertStatus(429);
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $this->token = auth('api')->attempt([
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer'.$this->token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Déconnexion réussie',
            ]);
    }

    /** @test */
    public function authenticated_user_can_refresh_token()
    {
        $this->token = auth('api')->attempt([
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer'.$this->token,
        ])->postJson('/api/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }
}
