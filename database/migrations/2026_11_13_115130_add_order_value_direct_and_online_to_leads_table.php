
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kiểm tra và thêm order_value_direct
        if (!Schema::hasColumn('leads', 'order_value_direct')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->integer('order_value_direct')->default(0);
            });
        }

        // Kiểm tra và thêm order_value_online
        if (!Schema::hasColumn('leads', 'order_value_online')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->integer('order_value_online')->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('leads', 'order_value_direct')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->dropColumn('order_value_direct');
            });
        }

        if (Schema::hasColumn('leads', 'order_value_online')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->dropColumn('order_value_online');
            });
        }
    }
};
