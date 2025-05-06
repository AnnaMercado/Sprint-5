<?php

namespace App\Services;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Comment;


class RoleService
{

    public function canViewAllUsers(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function canViewUserProfile(User $user)
    {
        return $user->hasRole('admin');
    }
    
    public function canUpdateUserProfile(User $user)
    {
        return $user->hasRole('admin');
    }

    public function canCreateRestaurant(User $user)
    {
        return $user->hasRole('admin');
    }

    public function canUpdateRestaurant(User $user)
    {
        return $user->hasRole('admin');
    }

    public function canDeleteRestaurant(User $user)
    {
        return $user->hasRole('admin');
    }

    public function canUpdateComment(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin') || $user->id === $comment->user_id;
    }
}