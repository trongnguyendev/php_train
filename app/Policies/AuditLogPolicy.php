<?php

namespace App\Policies;

use App\Models\AuditLog;
use App\Models\User;

class AuditLogPolicy
{

/**
     * Hàm phụ trợ kiểm tra xem User có phải là Sếp (Admin/Manager) không
     */
    private function isBoss(User $user): bool
    {
        // Kiểm tra xem trong các Role của User này có cái nào mang slug là 'admin' hoặc 'manager' không
        return $user->roles()->whereIn('slug', ['admin', 'manager', 'supporter'])->exists();
    }
    /**
     * Determine if the user can view any audit logs.
     */
    public function viewAny(User $user): bool
    {
            // 🔥 NOTE QUAN TRỌNG: Nếu là admin hoặc manager thì cho qua cửa index luôn không cần check permission tĩnh
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('audit_logs.view-any');
    }

    /**
     * Determine if the user can view the audit logs.
     */
    public function view(User $user, AuditLog $auditLog): bool
    {         // 🔥 NOTE QUAN TRỌNG: Nếu là admin hoặc manager thì cho qua cửa show luôn không cần check permission tĩnh
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('audit_logs.view');
    }

    /**
     * Determine if the user can create audit logs.
     */
    public function create(User $user): bool
    {
        if ($this->isBoss($user)) {
            return true;
        }   
        return $user->hasPermission('audit_logs.create');
    }

    /**
     * Determine if the user can update the audit log.
     */
    public function update(User $user, AuditLog $auditLog): bool
    {
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('audit_logs.update');
    }

    /**
     * Determine if the user can delete the audit log.
     */
    public function delete(User $user, AuditLog $auditLog): bool
    {
        if ($this->isBoss($user)) {
            return true;
        }
        return $user->hasPermission('audit_logs.delete');
    }
}

