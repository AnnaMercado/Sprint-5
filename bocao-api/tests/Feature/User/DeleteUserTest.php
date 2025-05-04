<?php

namespace Tests\Feature\User;

use Tests\Feature\ApiTestCase;

class DeleteUserTest extends ApiTestCase
{

    public function test_user_can_delete_account(): void
    {
        $this->createAuthenticatedUser();
        $userId = $this->user->id;
        
        $response = $this->deleteJson('/api/users', [], $this->authHeaders());

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('users', [
            'id' => $userId,
        ]);
    }

    public function test_not_user_cannot_delete_account(): void
    {
        $response = $this->deleteJson('/api/users');
        
        $response->assertStatus(401);
    }
}