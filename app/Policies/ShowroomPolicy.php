<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Showroom;

class ShowroomPolicy
{
    /**
     * Determine if the user can view any showrooms.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('showrooms.view-any');
    }

    /**
     * Determine if the user can view the showroom.
     */
    public function view(User $user, Showroom $showroom): bool
    {
        return $user->hasPermission('showrooms.view');
    }

    /**
     * Determine if the user can create showrooms.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('showrooms.create');
    }

    /**
     * Determine if the user can update the showroom.
     */
    public function update(User $user, Showroom $showroom): bool
    {
        return $user->hasPermission('showrooms.update');
    }

    /**
     * Determine if the user can delete the showroom.
     */
    public function delete(User $user, Showroom $showroom): bool
    {
        return $user->hasPermission('showrooms.delete');
    }
}

