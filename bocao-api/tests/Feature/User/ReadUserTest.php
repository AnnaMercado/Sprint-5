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
 
    public function test_admin_can_view_other_profiles(): void
    {
        $this->createAuthenticatedUser();
        
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        
        $this->user->assignRole('admin');
        
        $response = $this->getJson('/api/users/' . $adminUser->id, $this->authHeaders());

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $adminUser->id,
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                ]
            ]);
    }
    

    public function test_not_admin_cannot_view_other_profiles(): void
    {
        $this->createAuthenticatedUser();
        
        $User = User::factory()->create();
        
        $response = $this->getJson('/api/users/' . $User->id, $this->authHeaders());

        $response->assertStatus(403);
    }
}