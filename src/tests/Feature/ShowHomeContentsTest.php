<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Home;

class ShowHomeContentsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Home::create([
            'title' => 'Title of Content 1',
            'description' => 'descripion oh this content 1',
            'photo' => 'photo.jpg',
        ]);
    }

    public function test_show_all_contents()
    {
        $response = $this->get('/api');
        $response->assertStatus(200)->assertJsonStructure([
            'message', 'content', 'total_content'
        ]);
    }

    public function test_show_one_contents(){
        $response = $this->get('/api/show/2');
        $response->assertStatus(200)
        ->assertJson([
            'message' => "ok",
        ])
        ->assertJsonStructure([
            'content',
        ]);
    }

    public function test_show_one_contents_but_id_not_found(){
        $response = $this->get('/api/show/1');
        $response->assertStatus(404)
        ->assertJson([
            'message' => "err, not found",
        ]);
    }

}
