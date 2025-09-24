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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->date('customer_for_showroom'); 
            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->string('zalo_feedback')->nullable();
            $table->foreignId('province_id')->constrained('provinces')->onDelete('restrict');
            $table->foreignId('type_customer_yet_id')->constrained('type_customers')->onDelete('restrict');
            $table->foreignId('type_customer_id')->constrained('type_customers')->onDelete('restrict');
            $table->foreignId('type_showroom_id')->constrained('type_showrooms')->onDelete('restrict');
            $table->foreignId('type_category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('status_first_id')->constrained('statuses')->onDelete('restrict');
            $table->string('note_sale')->nullable();
            $table->foreignId('salename_infor_id')->constrained('sale_names')->onDelete('restrict');
            $table->foreignId('salename_support_id')->constrained('sale_names')->onDelete('restrict');
            $table->foreignId('current_status_id')->constrained('statuses')->onDelete('restrict');
            $table->decimal('order_value', 15, 2)->nullable();
            $table->foreignId('customer_support_yet_id')->constrained('sources')->onDelete('restrict');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
