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
        Schema::create('customer', function (Blueprint $table) { // Đổi từ 'customer_' thành 'customers'
                $table->id();
                $table->date('start_date'); // Đổi từ 'star_date' thành 'start_date' và dùng date()
                $table->string('name'); // Đổi từ text() thành string()
                $table->string('phone'); // Đổi từ phone() thành string()
                $table->string('province'); // Đổi từ text() thành string()
                $table->text('address');
                $table->string('type_customer'); // Đổi từ text() thành string()
                $table->string('page_source'); // Đổi từ text() thành string()
                $table->string('sale_product'); // Đổi từ text() thành string()
                $table->string('first_guest_status'); // Đổi từ text() thành string()
                $table->text('note');
                $table->text('sale_infor');
                $table->string('current_guest_status'); // Đổi từ text() thành string()
                $table->text('information_exchange');
                $table->text('results');
                $table->date('take_care_guest_first_one');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
