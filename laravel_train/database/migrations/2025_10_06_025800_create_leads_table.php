<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->date('customer_for_showroom')->nullable();
            $table->string('name', 255);
            $table->string('phone', 20)->nullable();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->string('address')->nullable();
            $table->string('zalo_feedback', 255)->nullable();
            $table->foreignId('type_customer_yet_id')->nullable()->constrained('type_customers')->nullOnDelete();
            $table->foreignId('type_customer_id')->nullable()->constrained('type_customers')->nullOnDelete();
            $table->foreignId('type_showroom_id')->nullable()->constrained('type_showrooms')->nullOnDelete();
            $table->foreignId('type_category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('status_first_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->string('note_sale', 255)->nullable();
            $table->foreignId('salename_infor_id')->nullable()->constrained('sale_names')->nullOnDelete();
            $table->foreignId('salename_support_id')->nullable()->constrained('sale_names')->nullOnDelete();
            $table->foreignId('current_status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->decimal('order_value', 15, 2)->nullable();
            $table->date('first_care_date')->nullable();
            $table->string('result1')->nullable();
            $table->date('two_care_date')->nullable();
            $table->string('result2')->nullable();
            $table->date('three_care_date')->nullable();
            $table->string('result3')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
