<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    /**
     * Determine if the user can view any leads.
     */
    public function viewAny(User $user): bool
    {
            // 🔥 NOTE QUAN TRỌNG: Nếu là admin hoặc manager thì cho qua cửa index luôn không cần check permission tĩnh
        if ($user->role && in_array($user->role->slug, ['admin', 'manager'])) {
            return true;
        }
        return $user->hasPermission('leads.view-any');
    }

    /**
     * Determine if the user can view the lead.
     */
    public function view(User $user, Lead $lead): bool
    {         // 🔥 NOTE QUAN TRỌNG: Nếu là admin hoặc manager thì cho qua cửa show luôn không cần check permission tĩnh
        if ($user->role && in_array($user->role->slug, ['admin', 'manager'])) {
            return true;
        }
        return $user->hasPermission('leads.view');
    }

    /**
     * Determine if the user can create leads.
     */
    public function create(User $user): bool
    {
        if ($user->role && in_array($user->role->slug, ['admin', 'manager'])) {
            return true;
        }   
        return $user->hasPermission('leads.create');
    }

    /**
     * Determine if the user can update the lead.
     */
    public function update(User $user, Lead $lead): bool
    {
        if ($user->role && in_array($user->role->slug, ['admin', 'manager'])) {
            return true;
        }
        return $user->hasPermission('leads.update');
    }

    /**
     * Determine if the user can delete the lead.
     */
    public function delete(User $user, Lead $lead): bool
    {
        if ($user->role && in_array($user->role->slug, ['admin', 'manager'])) {
            return true;
        }
        return $user->hasPermission('leads.delete');
    }
}

