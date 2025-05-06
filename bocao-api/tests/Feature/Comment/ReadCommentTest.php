<?php

namespace Tests\Feature\Comment;

use App\Models\Restaurant;
use App\Models\Comment;
use App\Models\User;
use Tests\Feature\ApiTestCase;

class ReadCommentTest extends ApiTestCase
{
    public function test_user_can_get_comments_for_restaurant(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create();

        Comment::factory()->count(2)->create([
            'restaurant_id' => $restaurant->id,
        ]);

        $response = $this->getJson("/api/restaurants/{$restaurant->id}/comments", $this->authHeaders());

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'content',
                             'user_id',
                             'restaurant_id',
                             'created_at',
                         ],
                     ],
                 ]);
    }

    public function test_non_user_cannot_get_comments(): void
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->getJson("/api/restaurants/{$restaurant->id}/comments");

        $response->assertStatus(401);
    }

    public function test_returns_empty_array_when_restaurant_has_no_comments(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create();

        $response = $this->getJson("/api/restaurants/{$restaurant->id}/comments", $this->authHeaders());

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [],
                 ]);
    }

    public function test_returns_404_if_restaurant_id_is_invalid(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->getJson("/api/restaurants/invalid-id/comments", $this->authHeaders());

        $response->assertStatus(404);
    }

    public function test_returns_404_if_restaurant_does_not_exist(): void
    {
        $this->createAuthenticatedUser();

        $nonExistentRestaurantId = 9999;

        $response = $this->getJson("/api/restaurants/{$nonExistentRestaurantId}/comments", $this->authHeaders());

        $response->assertStatus(404);
    }
}
