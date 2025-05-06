<?php

namespace Tests\Feature\Restaurant;

use App\Models\Restaurant;
use Tests\Feature\ApiTestCase;

class UpdateRestaurantTest extends ApiTestCase
{
    public function test_admin_can_update_restaurant(): void
    {
        $this->createAuthenticatedUser();
        $this->user->assignRole('admin');

        $restaurant = Restaurant::factory()->create([
            'name' => 'Old Restaurant',
            'address' => 'Old Address',
            'phone' => '555-1000',
        ]);

        $updatedData = [
            'name' => 'Updated Restaurant',
            'address' => 'New Address',
            'phone' => '555-2000',
        ];

        $response = $this->putJson('/api/restaurants/' . $restaurant->id, $updatedData, $this->authHeaders());

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Restaurant',
                'address' => 'New Address',
            ]);

        $this->assertDatabaseHas('restaurants', [
            'id' => $restaurant->id,
            'name' => 'Updated Restaurant',
            'address' => 'New Address',
        ]);
    }

    public function test_non_admin_cannot_update_restaurant(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create([
            'name' => 'Restaurant to Update',
            'address' => 'Street Address',
            'phone' => '555-1001',
        ]);

        $updatedData = [
            'name' => 'Updated Restaurant',
            'address' => 'New Address',
            'phone' => '555-2001',
        ];

        $response = $this->putJson('/api/restaurants/' . $restaurant->id, $updatedData, $this->authHeaders());

        $response->assertStatus(403);

        $this->assertDatabaseMissing('restaurants', [
            'name' => 'Updated Restaurant',
        ]);
    }

    public function test_not_user_cannot_update_restaurant(): void
    {
        $restaurant = Restaurant::factory()->create([
            'name' => 'Restaurant to Update',
            'address' => 'Street Address',
            'phone' => '555-1002',
        ]);

        $updatedData = [
            'name' => 'Updated Restaurant',
            'address' => 'New Address',
            'phone' => '555-2002',
        ];

        $response = $this->putJson('/api/restaurants/' . $restaurant->id, $updatedData);

        $response->assertStatus(401);
    }

    public function test_phone_must_be_string(): void
    {
        $this->createAuthenticatedUser();
        $this->user->assignRole('admin');

        $restaurant = Restaurant::factory()->create([
            'name' => 'Restaurant to Update',
            'address' => 'Street Address',
            'phone' => '555-1003',
        ]);

        $updatedData = [
            'name' => 'Updated Restaurant',
            'address' => 'New Address',
            'phone' => 12345678,
        ];

        $response = $this->putJson('/api/restaurants/' . $restaurant->id, $updatedData, $this->authHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_phone_must_be_unique(): void
    {
        $this->createAuthenticatedUser();
        $this->user->assignRole('admin');

        $restaurant1 = Restaurant::factory()->create([
            'name' => 'Restaurant 1',
            'address' => 'Street Address 1',
            'phone' => '555-1004',
        ]);

        $restaurant2 = Restaurant::factory()->create([
            'name' => 'Restaurant 2',
            'address' => 'Street Address 2',
            'phone' => '555-1005',
        ]);

        $updatedData = [
            'name' => 'Updated Restaurant',
            'address' => 'New Address',
            'phone' => '555-1005', 
        ];

        $response = $this->putJson('/api/restaurants/' . $restaurant1->id, $updatedData, $this->authHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }
}
