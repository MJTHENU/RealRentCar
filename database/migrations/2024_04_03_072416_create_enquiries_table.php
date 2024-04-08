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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->string('mobile_no');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('start_loc');
            $table->string('end_loc');
            $table->string('seat');
            $table->string('luggage');
            $table->string('vehicle_type');
            $table->enum('AC', ['yes','no']);
            $table->string('desc');
            $table->enum('journey_type', ['drop','drop&pickup']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
