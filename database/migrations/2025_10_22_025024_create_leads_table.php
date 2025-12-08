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
            $table->date('first_interaction_date');
            $table->string('name');
            $table->string('phone');
            $table->string('province_id');
            $table->text('address');
            $table->string('zalo');
            $table->string('customer_type_id');
            $table->string('showroom_id')->nullable();
            $table->string('first_customer_status_id')->nullable();
            $table->longtext('note');
            $table->string('sale_information_id');
            $table->string('sale_support_id')->nullable();
            $table->string('current_customer_status_id');
            $table->integer('order_value')->default(0);
            $table->string('support_channel_id')->nullable();
            $table->string('source_id')->nullable();
            $table->text('customer_discussion_details')->nullable();
            $table->string('tmdt')->nullable();
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
