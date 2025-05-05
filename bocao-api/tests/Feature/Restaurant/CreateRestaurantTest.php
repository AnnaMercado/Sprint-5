<?php

namespace Tests\Feature\Restaurant;

use Tests\Feature\ApiTestCase;
use App\Models\Restaurant;

class CreateRestaurantTest extends ApiTestCase
{
    public function test_restaurant_can_be_created(): void
    {
        $restaurantData = [
            'name' => 'La Esquina',
            'address' => 'Calle Falsa 123',
            'phone' => '555-1234',
        ];

        $response = $this->postJson('/api/restaurants', $restaurantData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'created_at',
                ],
            ]);

        $this->assertDatabaseHas('restaurants', [
            'name' => 'La Esquina',
            'address' => 'Calle Falsa 123',
        ]);
    }

    public function test_restaurant_requires_all_fields(): void
    {
        $response = $this->postJson('/api/restaurants', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'address', 'phone']);
    }

    public function test_phone_must_be_string(): void
    {
        $response = $this->postJson('/api/restaurants', [
            'name' => 'La Esquina',
            'address' => 'Calle Falsa 123',
            'phone' => 12345678,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_phone_must_be_unique(): void
    {
        Restaurant::create([
            'name' => 'Restaurant',
            'address' => 'Its street',
            'phone' => '555-1234',
        ]);

        $response = $this->postJson('/api/restaurants', [
            'name' => 'Other Restaurant',
            'address' => 'Other street',
            'phone' => '555-1234',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_admin_can_create_restaurant(): void
    {
        $this->createAuthenticatedUser();

        $this->user->assignRole('admin');

        $restaurantData = [
            'name' => 'Restaurant Admin',
            'address' => 'Admin Street 1',
            'phone' => '555-9999',
        ];

        $response = $this->postJson('/api/restaurants', $restaurantData, $this->authHeaders());

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'user_id',
                    'created_at',
                ]
            ]);

        $this->assertDatabaseHas('restaurants', [
            'name' => 'Restaurant Admin',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_not_admin_cannot_create_restaurant(): void
    {
        $this->createAuthenticatedUser(); 
    
        $restaurantData = [
            'name' => 'Restaurant User',
            'address' => 'User Street',
            'phone' => '555-8888',
        ];
    
        $response = $this->postJson('/api/restaurants', $restaurantData, $this->authHeaders());
    
        $response->assertStatus(403); 
    
        $this->assertDatabaseMissing('restaurants', [
            'name' => 'Restaurant User',
        ]);
    }
}
