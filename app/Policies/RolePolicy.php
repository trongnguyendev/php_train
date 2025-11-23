<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class RolePolicy
{
    /**
     * Determine if the user can view any roles.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('roles.view-any');
    }

    /**
     * Determine if the user can view the role.
     */
    public function view(User $user, Role $model): bool
    {
        return $user->hasPermission('roles.view');
    }

    /**
     * Determine if the user can create roles.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('roles.create');
    }

    /**
     * Determine if the user can update the role.
     */
    public function update(User $user, Role $model): bool
    {
        return $user->hasPermission('roles.update');
    }

    /**
     * Determine if the user can delete the role.
     */
    public function delete(User $user, Role $model): bool
    {
        return $user->hasPermission('roles.delete');
    }
}

