<?php

namespace Tests\Feature\User;

use Tests\Feature\ApiTestCase;
use App\Models\User;

class ReadUserTest extends ApiTestCase
{
   
    public function test_user_can_view_profile(): void
    {
        $this->createAuthenticatedUser();
        
        $response = $this->getJson('/api/users', $this->authHeaders());
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
            
        $response->assertJsonFragment([
            'email' => $this->user->email,
            'name' => 'Test User',
        ]);
        
        $this->assertCount(1, $response->json('data'));
    }

    public function test_unauthenticated_user_cannot_view_profile(): void
    {
        $response = $this->getJson('/api/users');
        
        $response->assertStatus(401);
    }
   
}