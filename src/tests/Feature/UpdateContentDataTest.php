<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Home;
use Tests\TestCase;

class UpdateContentDataTest extends TestCase
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

        Home::create([
            'title' => 'Title of Content 1',
            'description' => 'descripion oh this content 1',
            'photo' => 'photo.jpg',
        ]);

    }

    public function test_success_update_data(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $this->token = $login->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/admin/update/1', [
                'title' => 'Title Post Json 1 Updated',
                'description' => 'description on this Post 1 Updated',
                'photo' => 'post_photo.jpg Updated',
            ]);
        
        $response->assertStatus(201)
            ->assertJson([
                'message' => "ok",
            ]);
        
        
    }

    public function test_failed_update_data_unauthorized(): void
    {

        $token = "wrongToken";

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])
        ->put('/api/admin/update/1', [
            'title' => 'Title Post Json 1 Updated',
            'description' => 'description on this Post 1 Updated',
            'photo' => 'post_photo.jpg Updated',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => "Unauthenticated.",
            ]);
    }

    public function test_filed_update_data_conten_id_not_found(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $this->token = $login->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/admin/update/222', [
                'title' => 'Title Post Json 1 Updated',
                'description' => 'description on this Post 1 Updated',
                'photo' => 'post_photo.jpg Updated',
            ]);

        $response->assertStatus(404)
            ->assertJson([
                'message' => "err, Content id not Found",
            ]);
    }


    public function test_failed_update_data_invalid_json_request(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $this->token = $login->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/admin/update/1', [
                'title' => '',
                'description' => 'description on this Post 1 Updated',
                'photo' => 'post_photo.jpg Updated',
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
