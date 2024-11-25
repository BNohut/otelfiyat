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
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels');
            $table->foreignId('concept_id')->constrained('concepts');
            $table->foreignId('room_offering_id')->constrained('room_offerings');
            $table->foreignId('currency_id')->constrained('currencies');
            $table->string('number');
            $table->integer('bed_count');
            $table->double('adult_unit_price');
            $table->double('child_unit_price');
            $table->double('extra_concept_price_adult');
            $table->double('extra_concept_price_child');
            $table->dateTime('check_out_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_rooms');
    }
};
