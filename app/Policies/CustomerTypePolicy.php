<?php

namespace App\Policies;

use App\Models\CustomerType;
use App\Models\User;

class CustomerTypePolicy
{
    /**
     * Determine if the user can view any customer types.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('customer_types.view-any');
    }

    /**
     * Determine if the user can view the customer type.
     */
    public function view(User $user, CustomerType $customerType): bool
    {
        return $user->hasPermission('customer_types.view');
    }

    /**
     * Determine if the user can create customer types.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('customer_types.create');
    }

    /**
     * Determine if the user can update the customer type.
     */
    public function update(User $user, CustomerType $customerType): bool
    {
        return $user->hasPermission('customer_types.update');
    }

    /**
     * Determine if the user can delete the customer type.
     */
    public function delete(User $user, CustomerType $customerType): bool
    {
        return $user->hasPermission('customer_types.delete');
    }
}

