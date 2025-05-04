<?php

namespace App\Services;

use App\Models\User;

class RoleService
{

    public function canViewAllUsers(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function canViewUserProfile($user)
    {
        return $user->hasRole('admin');
    }
    public function canUpdateUserProfile($user)
    {
        return $user->hasRole('admin');
    }
}