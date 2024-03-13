<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase; 

    public function setUp(): void
    {
        parent::setUp();

        
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'exist@email.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_success_login(): void
    {

        $response = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Login successful',
            ])
            ->assertJsonStructure([
                'token',
            ]);
    }

    public function test_failed_login_email_not_exist(): void
    {

        $response = $this->postJson('/api/login', [
            'email' => 'notexist@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'email not found',
            ]);
    }

    public function test_failed_login_wrong_password(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'pass',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'invalid, wrong email or password',
            ]);
    }
}
