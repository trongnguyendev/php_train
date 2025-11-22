<?php

namespace App\Policies;

use App\Models\CustomerSource;
use App\Models\User;

class CustomerSourcePolicy
{
    /**
     * Determine if the user can view any customer sources.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('customer_sources.view-any');
    }

    /**
     * Determine if the user can view the customer source.
     */
    public function view(User $user, CustomerSource $customerSource): bool
    {
        return $user->hasPermission('customer_sources.view');
    }

    /**
     * Determine if the user can create customer sources.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('customer_sources.create');
    }

    /**
     * Determine if the user can update the customer source.
     */
    public function update(User $user, CustomerSource $customerSource): bool
    {
        return $user->hasPermission('customer_sources.update');
    }

    /**
     * Determine if the user can delete the customer source.
     */
    public function delete(User $user, CustomerSource $customerSource): bool
    {
        return $user->hasPermission('customer_sources.delete');
    }
}

