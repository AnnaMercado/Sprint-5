<?php

namespace Tests\Feature\Comment;

use Tests\Feature\ApiTestCase;
use App\Models\User;
use App\Models\Comment;
use App\Models\Restaurant;

class DeleteCommentTest extends ApiTestCase
{
    public function test_user_can_delete_own_comment(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $response = $this->deleteJson("/api/comments/{$comment->id}", [], $this->authHeaders());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_admin_can_delete_any_comment(): void
    {
        $this->createAuthenticatedUser();
        $this->user->assignRole('admin');

        $restaurant = Restaurant::factory()->create();
        $otherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $response = $this->deleteJson("/api/comments/{$comment->id}", [], $this->authHeaders());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_user_cannot_delete_other_users_comment(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create();
        $otherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $response = $this->deleteJson("/api/comments/{$comment->id}", [], $this->authHeaders());

        $response->assertStatus(403);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_not_user_cannot_delete_comment(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(401);
    }

    public function test_comment_must_exist_to_be_deleted(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->deleteJson("/api/comments/999999", [], $this->authHeaders());

        $response->assertStatus(404);
    }
}
