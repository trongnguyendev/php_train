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
        return $user->hasPermission('leads.view-any');
    }

    /**
     * Determine if the user can view the lead.
     */
    public function view(User $user, Lead $lead): bool
    {
        return $user->hasPermission('leads.view');
    }

    /**
     * Determine if the user can create leads.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('leads.create');
    }

    /**
     * Determine if the user can update the lead.
     */
    public function update(User $user, Lead $lead): bool
    {
        return $user->hasPermission('leads.update');
    }

    /**
     * Determine if the user can delete the lead.
     */
    public function delete(User $user, Lead $lead): bool
    {
        return $user->hasPermission('leads.delete');
    }
}

