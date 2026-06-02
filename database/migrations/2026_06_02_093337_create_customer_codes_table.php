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
        Schema::create('customer_codes', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính customer_id (tự tăng)
            
            // Tạo cột lưu mã khách hàng, gán thuộc tính UNIQUE để không bao giờ bị trùng lặp ở tầng DB
            $table->string('customer_code', 20)->unique(); 
            
            $table->timestamps(); // Tạo 2 cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_codes');
    }
};