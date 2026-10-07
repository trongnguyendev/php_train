<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->string('invoice_code')->unique();

            // Thông tin khách hàng
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('customer_address')->nullable();

            // Tính toán tổng số tiền & Chiết khấu
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_manual', 15, 2)->default(0);
            $table->decimal('discount_retail', 15, 2)->default(0);
            $table->decimal('discount_total', 15, 2)->default(0);

            // Thông tin Cọc, Phí khác & Số tiền còn lại
            $table->decimal('deposit_amount', 15, 2)->default(0);
            $table->string('deposit_type')->nullable();
            $table->decimal('other_fee', 15, 2)->default(0);
            $table->decimal('remaining', 15, 2)->default(0);

            // Tổng tiền sau cùng
            $table->decimal('grand_total', 15, 2)->default(0);

            // Thanh toán, Ghi chú & Nhân viên
            $table->string('payment_method')->default('Chuyển khoản');
            $table->text('note')->nullable();
            $table->string('sale_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};