<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine if the user can view any permissions.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('permissions.view-any');
    }

    /**
     * Determine if the user can view the permission.
     */
    public function view(User $user, Permission $model): bool
    {
        return $user->hasPermission('permissions.view');
    }

    /**
     * Determine if the user can create permissions.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('permissions.create');
    }

    /**
     * Determine if the user can update the permission.
     */
    public function update(User $user, Permission $model): bool
    {
        return $user->hasPermission('permissions.update');
    }

    /**
     * Determine if the user can delete the permission.
     */
    public function delete(User $user, Permission $model): bool
    {
        return $user->hasPermission('permissions.delete');
    }
}

