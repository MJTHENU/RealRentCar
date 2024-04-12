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
        Schema::create('tariff', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->enum('tariff_type', ['per_km', 'per_hr', 'per_day']);
            $table->string('price_per_km');
            $table->string('price_per_hr');
            $table->string('price_per_day');
            $table->string('max_km');
            $table->string('min_charge');
            $table->string('extra_km');
            $table->string('waiting_charge');
            $table->string('car_brand');
            $table->string('car_model');
            $table->string('vehicle_type');
            $table->enum('status', ['active', 'inactive' ])->default('active');
            $table->timestamps();
        });

    }

   
};