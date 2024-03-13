<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class StoreContentDataTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'exist@email.com',
            'password' => bcrypt('password'),
        ]);

    }

    public function test_success_store_data(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $this->token = $login->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/admin/store', [
                'title' => 'Title Post Json 1',
                'description' => 'description on this Post 1',
                'photo' => 'post_photo.jpg',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => "ok",
            ]);
    }

    public function test_failed_store_data_unauthorized(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . "WrongToken")
        ->postJson('/api/admin/store', [
            'title' => 'Title Post Json 1',
            'description' => 'description on this Post 1',
            'photo' => 'post_photo.jpg',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => "Unauthenticated.",
            ]);
    }

    public function test_failed_store_data_invalid_json_request(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $this->token = $login->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/admin/store', [
                'title' => 'Title Post Json 1',
                'description' => '',
                'photo' => 'post_photo.jpg',
            ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => "err",
            ])
            ->assertJsonStructure([
                'errors',
            ]);
    }

    
}
