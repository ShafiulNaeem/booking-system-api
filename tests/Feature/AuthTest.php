<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    /** @test */
    public function user_can_registration(): void
    {
        $response = $this->post('/api/v1/register', [
            'email' => 'test124@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'name' => 'Test User',
            'role' => 'guest'
        ]);

        $response->assertStatus(200);
        $response->dd();
    }
    /** @test */
    public function user_can_login(): void
    {
        $response = $this->post('/api/v1/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200);
        $response->dump();
    }
    /** @test */
    public function user_can_logout(): void
    {
        $user = User::where('email', 'test@gmail.com')->first();
        $token = auth()->login($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/v1/logout');
        $response->assertStatus(200);
        $response->dump();
    }
    /** @test */
    public function user_can_logout_without_tocken(): void
    {
        $response = $this->post('/api/v1/logout');
        $response->assertStatus(401);
        $response->dump();
    }
}
