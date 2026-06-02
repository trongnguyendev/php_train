<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // 1. Thêm cột khóa ngoại customer_id liên kết sang bảng customer_codes
            // Khai báo là nullable() phòng trường hợp dữ liệu cũ chưa có id khách hàng ngay
            $table->foreignId('customer_id')
                  ->nullable()
                  ->after('id') // Đặt ngay sau cột id của bảng leads
                  ->constrained('customer_codes')
                  ->onDelete('set null'); // Nếu xóa khách hàng, đơn hàng giữ nguyên và set null id

            // 2. Đổi tên cột customer_code thành order_code
            $table->renameColumn('customer_code', 'order_code');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Hoàn tác lại nếu cần rollback
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            $table->renameColumn('order_code', 'customer_code');
        });
    }
};