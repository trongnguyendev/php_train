<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\SaleUser;

class SaleUserPolicy
{
    /**
     * Determine if the user can view any sale users.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('sale_users.view-any');
    }

    /**
     * Determine if the user can view the sale user.
     */
    public function view(User $user, SaleUser $saleUser): bool
    {
        return $user->hasPermission('sale_users.view');
    }

    /**
     * Determine if the user can create sale users.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('sale_users.create');
    }

    /**
     * Determine if the user can update the sale user.
     */
    public function update(User $user, SaleUser $saleUser): bool
    {
        return $user->hasPermission('sale_users.update');
    }

    /**
     * Determine if the user can delete the sale user.
     */
    public function delete(User $user, SaleUser $saleUser): bool
    {
        return $user->hasPermission('sale_users.delete');
    }
}

