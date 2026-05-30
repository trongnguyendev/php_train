<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    /**
     * Determine if the user can view any leads.
     */
    // public function viewAny(User $user): bool
    // {
    //     return $user->hasPermission('leads.view-any');
    // }

        /**
     * Determine if the user can view the lead.
     * (Quyền xem chi tiết một Lead cụ thể)
     */
    public function viewAny(User $user, Lead $lead): bool
    {
        // 1. Nếu là Quản lý/Admin -> Cho phép xem hết không cần check chủ sở hữu
        if ($user->role === 'manager' || $user->role === 'admin' || $user->hasPermission('leads.view-all')) {
            return true;
        }

        // 2. Nếu là nhân viên thông thường -> Phải có quyền xem cơ bản AND phải là người phụ trách Lead đó
        return $user->hasPermission('leads.view-any') 
            && ($user->id === $lead->sale_information_id || $user->id === $lead->sale_support_id);
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

