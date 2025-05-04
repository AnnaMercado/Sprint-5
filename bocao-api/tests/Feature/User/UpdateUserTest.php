<?php

namespace Tests\Feature\User;

use Tests\Feature\ApiTestCase;
use App\Models\User;

class UpdateUserTest extends ApiTestCase
{
    
    public function test_authenticated_user_can_update_user(): void
    {
        $this->createAuthenticatedUser();
        
        $updatedData = [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ];
        
        $response = $this->putJson('/api/users', $updatedData, $this->authHeaders());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
            
        $response->assertJson([
            'data' => [
                'name' => 'New Name',
                'email' => 'new@example.com',
            ]
        ]);
        
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

  

    public function test_email_must_mail(): void
    {
        $this->createAuthenticatedUser();
        
        $response = $this->putJson('/api/users', [
            'email' => 'not_a_email'
        ], $this->authHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

  
    public function test_email_must_be_unique(): void
    {
        $this->createAuthenticatedUser();
        
        $anotherUser = User::factory()->create([
            'email' => 'uniquemail@example.com'
        ]);
        
        $response = $this->putJson('/api/users', [
            'email' => 'uniquemail@example.com'
        ], $this->authHeaders());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }


    public function test_not_user_cannot_update_user(): void
    {
        $response = $this->putJson('/api/users', [
            'name' => 'not_a_user'
        ]);
        
        $response->assertStatus(401);
    }
    

    public function test_admin_can_update_another_user(): void
    {
        $this->createAuthenticatedUser();
        $this->user->assignRole('admin');
        
        // Create another user
        $User = User::factory()->create([
            'name' => 'User',
            'email' => 'User@example.com',
        ]);
        
        $updatedData = [
            'name' => 'New Name',
        ];
        
        $response = $this->putJson('/api/users/' . $anotherUser->id, $updatedData, $this->authHeaders());

        $response->assertStatus(200);
        
        // Verify database was updated
        $this->assertDatabaseHas('users', [
            'id' => $User->id,
            'name' => 'New Name',
        ]);
    }
    

    public function test_not_admin_cannot_update_another_profile(): void
    {
        $this->createAuthenticatedUser();
        
        $User = User::factory()->create();
        
        $response = $this->putJson('/api/users/' . $User->id, [
            'name' => 'Other name'
        ], $this->authHeaders());

        $response->assertStatus(403);
        
        $this->assertDatabaseMissing('users', [
            'id' => $User->id,
            'name' => 'Other Name',
        ]);
    }
}