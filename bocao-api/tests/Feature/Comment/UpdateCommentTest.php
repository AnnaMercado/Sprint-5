<?php

namespace Tests\Feature\Comment;

use Tests\Feature\ApiTestCase;
use App\Models\User;
use App\Models\Comment;
use App\Models\Restaurant;

class UpdateCommentTest extends ApiTestCase
{
    public function test_user_can_update_own_comment(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'restaurant_id' => $restaurant->id,
            'content' => 'Original comment',
        ]);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Updated comment'
        ], $this->authHeaders());

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'content' => 'Updated comment'
                 ]);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'Updated comment',
        ]);
    }

    public function test_admin_can_update_any_comment(): void
    {
        $this->createAuthenticatedUser();
        $this->user->assignRole('admin');

        $restaurant = Restaurant::factory()->create();
        $otherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'restaurant_id' => $restaurant->id,
            'content' => 'Original comment',
        ]);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Admin updated comment'
        ], $this->authHeaders());

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'content' => 'Admin updated comment'
                 ]);
    }

    public function test_user_cannot_update_other_users_comment(): void
    {
        $this->createAuthenticatedUser();

        $restaurant = Restaurant::factory()->create();
        $otherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'restaurant_id' => $restaurant->id,
            'content' => 'Original comment',
        ]);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Attempted update'
        ], $this->authHeaders());

        $response->assertStatus(403);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'content' => 'Attempted update',
        ]);
    }

    public function test_comment_cannot_be_empty(): void
    {
        $this->createAuthenticatedUser();

        $comment = Comment::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->putJson("/api/comments/{$comment->id}", [], $this->authHeaders());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['content']);
    }

    public function test_content_has_to_be_string(): void
    {
        $this->createAuthenticatedUser();

        $comment = Comment::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 12345
        ], $this->authHeaders());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['content']);
    }

}