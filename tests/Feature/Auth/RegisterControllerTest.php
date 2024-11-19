<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data()
    {
        $data = [
            'name' => 'Hasnain Khan',
            'email' => fake()->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                     'token',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }


    public function test_user_cannot_register_with_missing_name()
    {
        $data = [
            'email' => fake()->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    public function test_user_cannot_register_with_invalid_email()
    {
        $data = [
            'name' => 'Hasnain Khan',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_register_with_password_mismatch()
    {
        $data = [
            'name' => 'Hasnain Khan',
            'email' => fake()->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }

    public function test_user_cannot_register_with_taken_email()
    {
        $existingEmail = 'existing@example.com';

        User::factory()->create([
            'email' => $existingEmail,
        ]);

        $data = [
            'name' => 'Hasnain Khan',
            'email' => $existingEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }
}
