<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Tạo khóa ngoại liên kết tới bảng users, cho phép null nếu muốn
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            
            // HOẶC nếu bạn chỉ muốn lưu ID dạng số bình thường, không tạo ràng buộc khóa ngoại:
            // $table->unsignedBigInteger('created_by')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Xóa khóa ngoại và xóa cột khi rollback
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};