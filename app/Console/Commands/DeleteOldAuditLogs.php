<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteOldAuditLogs extends Command
{
    protected $signature = 'audit-logs:cleanup';

    protected $description = 'Xóa audit logs cũ hơn 90 ngày';

    public function handle(): int
    {
        $cutoffDate = Carbon::now()->subDays(90);

        $deleted = AuditLog::where('created_at', '<', $cutoffDate)->delete();

        $this->info("Đã xóa {$deleted} audit logs cũ hơn 90 ngày.");

        return self::SUCCESS;
    }
}