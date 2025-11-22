<?php

namespace App\Policies;

use App\Models\ProductCategory;
use App\Models\User;

class ProductCategoryPolicy
{
    /**
     * Determine if the user can view any product categories.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('product_categories.view-any');
    }

    /**
     * Determine if the user can view the product category.
     */
    public function view(User $user, ProductCategory $productCategory): bool
    {
        return $user->hasPermission('product_categories.view');
    }

    /**
     * Determine if the user can create product categories.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('product_categories.create');
    }

    /**
     * Determine if the user can update the product category.
     */
    public function update(User $user, ProductCategory $productCategory): bool
    {
        return $user->hasPermission('product_categories.update');
    }

    /**
     * Determine if the user can delete the product category.
     */
    public function delete(User $user, ProductCategory $productCategory): bool
    {
        return $user->hasPermission('product_categories.delete');
    }
}

