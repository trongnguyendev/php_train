<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{

/**
     * Hàm phụ trợ kiểm tra xem User có phải là Sếp (Admin/Manager) không
     */
    private function isBoss(User $user): bool
    {
        // Kiểm tra xem trong các Role của User này có cái nào mang slug là 'admin' hoặc 'manager' không
        return $user->roles()->whereIn('slug', ['admin', 'manager'])->exists();
    }
    /**
     * Determine if the user can view any leads.
     */
    public function viewAny(User $user): bool
    {
            // 🔥 NOTE QUAN TRỌNG: Nếu là admin hoặc manager thì cho qua cửa index luôn không cần check permission tĩnh
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('leads.view-any');
    }

    /**
     * Determine if the user can view the lead.
     */
    public function view(User $user, Lead $lead): bool
    {         // 🔥 NOTE QUAN TRỌNG: Nếu là admin hoặc manager thì cho qua cửa show luôn không cần check permission tĩnh
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('leads.view');
    }

    /**
     * Determine if the user can create leads.
     */
    public function create(User $user): bool
    {
        if ($this->isBoss($user)) {
            return true;
        }   
        return $user->hasPermission('leads.create');
    }

    /**
     * Determine if the user can update the lead.
     */
    public function update(User $user, Lead $lead): bool
    {
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('leads.update');
    }

    /**
     * Determine if the user can delete the lead.
     */
    public function delete(User $user, Lead $lead): bool
    {
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('leads.delete');
    }
}

