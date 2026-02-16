<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class ReportPolicy
{
    public function reportDaily(User $user)
    {
        return $user->hasPermission('report_daily');
    }

    public function reportMonth(User $user)
    {
        return $user->hasPermission('report_month');
    }

    public function reportShowroom(User $user)
    {
        return $user->hasPermission('report_showroom');
    }
}
