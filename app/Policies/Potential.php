<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Potential;

class PotentialPolicy
{
    /**
     * Determine if the user can view any potentials.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('potential.view');
    }

}