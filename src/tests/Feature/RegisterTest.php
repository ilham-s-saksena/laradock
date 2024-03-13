<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
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

    public function test_success_registered(){
        $response = $this->postJson('/api/register', [
            'name' => 'Jhony',
            'email' => 'jhony@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                "message" => "ok, success refistered"
            ]);
    }

    public function test_failed_register_email_already_exist(){
        $response = $this->postJson('/api/register', [
            'name' => 'Jhony',
            'email' => 'exist@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                "message"=> "err, email already exist"
            ]);
    }

    public function test_failed_register_not_valid_email(){
        $response = $this->postJson('/api/register', [
            'name' => 'Jhony',
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => "err",
            ])
            ->assertJsonStructure([
                'errors',
            ]);
    }

    public function test_failed_register_no_name_filed(){
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'newemail@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => "err",
            ])
            ->assertJsonStructure([
                'errors',
            ]);
    }


    public function test_failed_register_no_name_password(){
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'newemail@gmail.com',
            'password' => '',
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
