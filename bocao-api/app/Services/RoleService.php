<?php

namespace App\Services;

use App\Models\User;

class RoleService
{

    public function canViewAllUsers(User $user): bool
    {
        return $user->hasRole('admin');
    }

}