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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('car_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('start_km', 10, 0)->default(0);
            $table->decimal('end_km', 10, 0)->default(0);
            $table->time('start_hr')->default(0);
            $table->time('end_hr')->default(0);
            $table->enum('plan_type', ['per_km', 'per_hr', 'per_day', '']);
            $table->integer('days')->nullable();
            $table->decimal('kilometer', 10, 0)->nullable();
            $table->decimal('hours', 10, 0)->nullable();
            $table->integer('price_per_km')->default(0);
            $table->integer('price_per_hr')->default(0);
            $table->decimal('price_per_day', 10, 2)->default(0);
            $table->decimal('total_price', 8, 2)->default(0);
            $table->string('status', 255)->default('active');
            $table->string('payment_method', 255)->nullable();
            $table->string('payment_status', 255)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
