<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_users()
    {
        // Create test users
        $users = User::factory()->count(3)->create();

        // Send GET request to the index route
        $response = $this->get('api/users');

        // Assert response status code and JSON structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                        'posts' => [
                            '*' => [
                                'id',
                                'title',
                                'content',
                                'created_at',
                                'updated_at',
                            ],
                        ],
                    ],
                ],
            ]);

        // Assert that the returned users exist in the database
        $response->assertJsonFragment($users->first()->toArray());
    }


    public function create_a_user()
    {
        // Create test data
        $userData = [
            'name' => 'example name',
            'email' => 'example@example.com',
            'password' => 'password123',
        ];

        // Send POST request to the store route
        $response = $this->post('api/users', $userData);

        // Assert response status code and JSON structure
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);

        // Assert that the user exists in the database
        $response->assertJsonFragment($userData);
    }

    /** @test */
    public function show_a_user()
    {
        // Create a test user
        $user = User::factory()->create();

        // Send GET request to the show route
        $response = $this->get('api/users/' . $user->id);

        // Assert response status code and JSON structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'posts' => [
                        '*' => [
                            'id',
                            'title',
                            'content',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ]);

        // Assert that the returned user exists in the database
        $response->assertJsonFragment($user->toArray());
    }

    /** @test */
    public function update_a_user()
{
    // Create a test user
    $user = User::factory()->create();

    // Update data for the user (excluding the password field)
    $updatedData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ];

    // Send PUT request to the update route
    $response = $this->put('api/users/' . $user->id, $updatedData);

    // Assert response status code and JSON structure
    $response->assertStatus(200);

    // Assert that the user was updated in the database
    $this->assertDatabaseHas('users', $updatedData);

    // Assert that the user was updated in the database
    $response->assertJsonFragment($updatedData);
}


    /** @test */
    public function delete_a_user()
    {
        // Create a test user
        $user = User::factory()->create();

        // Send DELETE request to the destroy route
        $response = $this->delete('api/users/' . $user->id);

        // Assert response status code
        $response->assertStatus(200);

        // Assert that the user no longer exists in the database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

}
