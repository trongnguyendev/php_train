<?php

namespace App\Policies;

use App\Models\Province;
use App\Models\User;

class ProvincePolicy
{
    /**
     * Determine if the user can view any provinces.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('provinces.view-any');
    }

    /**
     * Determine if the user can view the province.
     */
    public function view(User $user, Province $province): bool
    {
        return $user->hasPermission('provinces.view');
    }

    /**
     * Determine if the user can create provinces.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('provinces.create');
    }

    /**
     * Determine if the user can update the province.
     */
    public function update(User $user, Province $province): bool
    {
        return $user->hasPermission('provinces.update');
    }

    /**
     * Determine if the user can delete the province.
     */
    public function delete(User $user, Province $province): bool
    {
        return $user->hasPermission('provinces.delete');
    }
}

