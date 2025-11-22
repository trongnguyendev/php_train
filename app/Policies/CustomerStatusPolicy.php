<?php

namespace App\Policies;

use App\Models\CustomerStatus;
use App\Models\User;

class CustomerStatusPolicy
{
    /**
     * Determine if the user can view any customer statuses.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('customer_statuses.view-any');
    }

    /**
     * Determine if the user can view the customer status.
     */
    public function view(User $user, CustomerStatus $customerStatus): bool
    {
        return $user->hasPermission('customer_statuses.view');
    }

    /**
     * Determine if the user can create customer statuses.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('customer_statuses.create');
    }

    /**
     * Determine if the user can update the customer status.
     */
    public function update(User $user, CustomerStatus $customerStatus): bool
    {
        return $user->hasPermission('customer_statuses.update');
    }

    /**
     * Determine if the user can delete the customer status.
     */
    public function delete(User $user, CustomerStatus $customerStatus): bool
    {
        return $user->hasPermission('customer_statuses.delete');
    }
}

