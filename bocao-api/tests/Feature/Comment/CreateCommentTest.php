<?php
    namespace Tests\Feature\Comment;

    use App\Models\Restaurant;
    use App\Models\Comment;
    use Tests\Feature\ApiTestCase;

    class CreateCommentTest extends ApiTestCase
    {
        public function test_user_can_create_comment(): void
        {
            $this->createAuthenticatedUser();

            $restaurant = Restaurant::factory()->create();

            $commentData = [
                'content' => 'Nice food.',
            ];

            $response = $this->postJson("/api/restaurants/{$restaurant->id}/comments", $commentData, $this->authHeaders());

            // Verificar respuesta exitosa
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'content',
                        'user_id',
                        'restaurant_id',
                        'created_at',
                    ],
                ]);

            $this->assertDatabaseHas('comments', [
                'content' => 'Nice food.',
                'user_id' => $this->user->id,
                'restaurant_id' => $restaurant->id,
            ]);
        }

        public function test_non_user_cannot_create_comment(): void
        {
            $restaurant = Restaurant::factory()->create();

            $commentData = [
                'content' => 'Really nice food.',
            ];

            $response = $this->postJson("/api/restaurants/{$restaurant->id}/comments", $commentData);

            $response->assertStatus(401);
        }

        public function test_comment_requires_content(): void
        {
            $this->createAuthenticatedUser();
            $restaurant = Restaurant::factory()->create();
    
            $response = $this->postJson("/api/restaurants/{$restaurant->id}/comments", [], $this->authHeaders());
    
            $response->assertStatus(422)
                     ->assertJsonValidationErrors(['content']);
        }
    
        public function test_comment_content_must_be_string(): void
        {
            $this->createAuthenticatedUser();
            $restaurant = Restaurant::factory()->create();
    
            $response = $this->postJson("/api/restaurants/{$restaurant->id}/comments", [
                'content' => 12345, 
            ], $this->authHeaders());
    
            $response->assertStatus(422)
                     ->assertJsonValidationErrors(['content']);
        }
    
    public function test_comment_cannot_be_created_for_nonexistent_restaurant(): void
        {
            $this->createAuthenticatedUser();
    
            $response = $this->postJson("/api/restaurants/9999/comments", [
                'content' => 'That restaurant does not exist',
            ], $this->authHeaders());
    
            $response->assertStatus(404);
        }
    }