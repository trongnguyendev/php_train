<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_take_cares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->longText('take_care_plan')->nullable();
            $table->date('take_care_date')->nullable();
            $table->text('take_care_result')->nullable();
            $table->timestamps();

            $table->foreign('lead_id')
                  ->references('id')
                  ->on('leads')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_take_cares');
    }
};
