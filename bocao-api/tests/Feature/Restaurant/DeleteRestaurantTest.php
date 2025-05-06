<?php

namespace Tests\Feature\Restaurant;

use App\Models\Restaurant;
use Tests\Feature\ApiTestCase;

class DeleteRestaurantTest extends ApiTestCase
{
    public function test_admin_can_delete_restaurant(): void
    {
        $this->createAuthenticatedUser();
        $this->user->assignRole('admin');

        $restaurant = Restaurant::factory()->create();

        $response = $this->deleteJson('/api/restaurants/' . $restaurant->id, [], $this->authHeaders());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('restaurants', [
            'id' => $restaurant->id,
        ]);
    }

    public function test_non_admin_cannot_delete_restaurant(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create();

        $response = $this->deleteJson('/api/restaurants/' . $restaurant->id, [], $this->authHeaders());

        $response->assertStatus(403);

        $this->assertDatabaseHas('restaurants', [
            'id' => $restaurant->id,
        ]);
    }

    public function test_not_user_cannot_delete_restaurant(): void
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->deleteJson('/api/restaurants/' . $restaurant->id);

        $response->assertStatus(401);

        $this->assertDatabaseHas('restaurants', [
            'id' => $restaurant->id,
        ]);
    }
}
