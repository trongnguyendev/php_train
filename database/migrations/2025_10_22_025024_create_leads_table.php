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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->date('first_arrival_date');
            $table->string('name');
            $table->string('phone');
            $table->string('province_id');
            $table->text('address');
            $table->string('zalo');
            $table->string('customer_type_id');
            $table->string('is_new_customer');
            $table->string('customer_source_id');
            $table->string('product_category_id');
            $table->string('showroom_id');
            $table->string('first_customer_status_id');
            $table->longtext('note');
            $table->string('sale_receive_customer_info_id');
            $table->string('sale_support_id');
            $table->string('current_customer_status_id');
            $table->integer('order_value')->default(0)->change();
            $table->string('support_status_customer_id');
            $table->text('exchange_content');
            $table->string('results')->default('')->change();
            $table->string('lead_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
