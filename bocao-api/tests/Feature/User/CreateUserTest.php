<?php

namespace Tests\Feature\User;

use Tests\Feature\ApiTestCase;
use App\Models\User;

class CreateUserTest extends ApiTestCase
{
    /**
     * Test successful user registration
     */
    public function test_user_can_register_successfully(): void
    {
        $userData = [
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'created_at',
                ],
                'token',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@example.com',
            'name' => 'User',
        ]);

        $user = User::where('email', 'user@example.com')->first();
        $this->assertTrue($user->hasRole('user'));
    }

    /**
     * Test validation for required fields
     */
    public function test_register_requires_all_fields(): void
    {
        $response = $this->postJson('/api/users', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_register_requires_unique_email(): void
    {
        User::factory()->create([
            'email' => 'anna@example.com',
        ]);

        $userData = [
            'name' => 'anna',
            'email' => 'anna@example.com',
            'password' => '12345jas',
            'password_confirmation' => '12345jas',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }


    public function test_password_must_match_confirmation(): void
    {
        $userData = [
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => '12345678',
            'password_confirmation' => 'not_that_password',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }


    public function test_password_must_be_minimum_length(): void
    {
        $userData = [
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => '1',
            'password_confirmation' => '1',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }



    public function test_email_must_be_valid_format(): void
    {
        $userData = [
            'name' => 'User',
            'email' => 'not_a_mail',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}