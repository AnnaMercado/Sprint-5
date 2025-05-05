<?php

namespace Tests\Feature\Restaurant;

use App\Models\Restaurant;
use Tests\Feature\ApiTestCase;

class ReadRestaurantTest extends ApiTestCase
{

    public function test_authenticated_user_can_get_restaurants_list(): void
    {
        // Crear un restaurante
        $restaurant = Restaurant::factory()->create([
            'name' => 'Test',
            'address' => 'Calle test 123',
            'phone' => '555-1234',
        ]);

        $this->createAuthenticatedUser();

        $response = $this->getJson('/api/restaurants', $this->authHeaders());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'address',
                        'phone',
                        'created_at',
                    ],
                ],
            ])
            ->assertJsonFragment([
                'name' => 'Test',
                'address' => 'Calle test 123',
                'phone' => '555-1234',
            ]);
    }


    public function test_unauthenticated_user_cannot_get_restaurants_list(): void
    {
        $response = $this->getJson('/api/restaurants');

        $response->assertStatus(401);
    }


    public function test_authenticated_user_can_view_single_restaurant(): void
    {
        $restaurant = Restaurant::factory()->create([
            'name' => 'Test 1',
            'address' => 'Calle test 123',
            'phone' => '555-1234',
        ]);

        $this->createAuthenticatedUser();

        $response = $this->getJson("/api/restaurants/{$restaurant->id}", $this->authHeaders());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJsonFragment([
                'name' => 'Test 1',
                'address' => 'Calle test 123',
                'phone' => '555-1234',
            ]);
    }

    public function test_unauthenticated_user_cannot_view_single_restaurant(): void
    {
        $restaurant = Restaurant::factory()->create([
            'name' => 'Test 2',
            'address' => 'Calle test 123',
            'phone' => '555-1234',
        ]);

        $response = $this->getJson("/api/restaurants/{$restaurant->id}");

        $response->assertStatus(401);
    }
}
