<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {

            $table->id();

            // Hóa đơn
            $table->foreignId('invoice_id')
                ->constrained('invoices')
                ->cascadeOnDelete();

            // Sản phẩm gốc
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            // Snapshot tên sản phẩm
            $table->string('product_name');

            // Snapshot giá lúc bán
            $table->decimal('unit_price', 15, 2)->default(0);

            // Số lượng
            $table->decimal('quantity', 15, 2)->default(1);

            // Giá × SL
            $table->decimal('subtotal', 15, 2)->default(0);

            // CK tay:
            // percent = %
            // amount  = tiền
            $table->string('manual_discount_type', 20)->nullable();

            // CK tay %
            $table->decimal('manual_discount_percent', 8, 2)
                ->default(0);

            // CK tay bằng tiền
            $table->decimal('manual_discount_amount', 15, 2)
                ->default(0);

            // CK lẻ
            $table->decimal('retail_discount', 15, 2)
                ->default(0);

            // Tổng CK dòng
            $table->decimal('discount_total', 15, 2)
                ->default(0);

            // Thành tiền sau CK
            $table->decimal('total', 15, 2)
                ->default(0);

            $table->timestamps();

            $table->index('invoice_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};