<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_posts()
    {
        // Create some test posts
        Post::factory()->count(5)->create();

        // Send GET request to the index route
        $response = $this->get('/api/posts');

        // Assert response status code and JSON structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'content',
                        'user_id',
                        'created_at',
                        'updated_at',
                        'user' => [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ]);
    }

    /** @test */



    /** @test */
    public function show_a_post()
    {
        // Create a test post
        $post = Post::factory()->create();

        // Send GET request to the show route
        $response = $this->get('/api/posts/' . $post->id);

        // Assert response status code and JSON structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'user_id',
                    'created_at',
                    'updated_at',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);

        // Assert that the response JSON matches the post data
        $response->assertJsonFragment($post->toArray());
    }

    /** @test */
    public function update_a_post()
    {
         // Create a test user
    $user = User::factory()->create();

    // Create a test post
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Data for updating the post
    $updatedData = [
        'title' => 'Updated Title',
        'content' => 'Updated content.',
        'user_id' => $user->id, // Use the user's id as the user_id for the updated post
    ];

    // Send PUT request to the update route
    $response = $this->put('/api/posts/' . $post->id, $updatedData);

    // Assert response status code and JSON structure
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'content',
                'user_id',
                'created_at',
                'updated_at',
            ],
        ]);

    // Assert that the post was updated in the database
    $this->assertDatabaseHas('posts', $updatedData);

    // Assert that the password field is not present in the JSON response
    $response->assertJsonMissing(['password']);
    }

    /** @test */
    public function delete_a_post()
    {
        // Create a test post
        $post = Post::factory()->create();

        // Send DELETE request to the destroy route
        $response = $this->delete('/api/posts/' . $post->id);

        // Assert response status code
        $response->assertStatus(200);

        // Assert that the post no longer exists in the database
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
