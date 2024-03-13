<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Home;
use Tests\TestCase;

class DeleteContentDataTest extends TestCase
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

    public function test_success_delete_data(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $this->token = $login->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->delete('/api/admin/delete/1');
        
        $response->assertStatus(201)
            ->assertJson([
                'message' => "ok",
            ]);
        
        
    }

    public function test_filed_delete_data_conten_id_not_found(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $this->token = $login->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->delete('/api/admin/delete/222');

        $response->assertStatus(404)
            ->assertJson([
                'message' => "err, Content id not Found",
            ]);
    }


    public function test_failed_update_data_unauthorized(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . "WrongToken"
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




}