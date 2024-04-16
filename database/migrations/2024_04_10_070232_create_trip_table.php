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
        Schema::create('trip', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('booking_id')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('tariff_id')->nullable();
            $table->string('start_loc')->nullable();
            $table->string('end_loc')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->time('start_hr')->nullable();
            $table->time('end_hr')->nullable();
            $table->string('start_km')->nullable();
            $table->string('end_km')->nullable();
            $table->string('extra_km')->nullable();
            $table->string('extra_charge')->nullable();
            $table->string('min_charge')->nullable();
            $table->string('waiting_charge')->nullable();
            $table->string('toll_charge')->nullable();
            $table->string('other_charges')->nullable();
            $table->string('total_amount')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('status', ['process', 'start', 'complete', 'cancelled', 'partially completed' ])->default('process');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip');
    }
};