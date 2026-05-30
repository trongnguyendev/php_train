<?php

namespace App\Policies;

use App\Models\SupportChannel;
use App\Models\User;

class SupportChannelPolicy
{
    /**
     * Determine if the user can view any customer types.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('support-channels.view-any');
    }

    /**
     * Determine if the user can view the customer type.
     */
    public function view(User $user, SupportChannel $supportChannel): bool
    {
        return $user->hasPermission('support-channels.view');
    }

    /**
     * Determine if the user can create customer types.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('support-channels.create');
    }

    /**
     * Determine if the user can update the customer type.
     */
    public function update(User $user, SupportChannel $supportChannel): bool
    {
        return $user->hasPermission('support-channels.update');
    }

    /**
     * Determine if the user can delete the customer type.
     */
    public function delete(User $user, SupportChannel $supportChannel): bool
    {
        return $user->hasPermission('support-channels.delete');
    }
}

