<?php

namespace Tests\Feature\Auth;

use Tests\Feature\ApiTestCase;

class LogoutTest extends ApiTestCase
{
   
    public function test_uthenticated_user_can_logout(): void
    {
        $this->createAuthenticatedUser();
        
        $response = $this->deleteJson('/api/tokens', [], $this->authHeaders());

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }


    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->deleteJson('/api/tokens');

        $response->assertStatus(401);
    }
}