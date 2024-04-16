<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->enum('tariff_type', ['per_km', 'per_hr', 'per_day']);
            $table->decimal('price_per_km', 8, 2)->nullable();
            $table->decimal('price_per_hr', 8, 2)->nullable();
            $table->decimal('price_per_day', 8, 2)->nullable();
            $table->integer('max_km')->nullable();
            $table->decimal('min_charge', 8, 2)->nullable();
            $table->decimal('extra_km', 8, 2)->nullable();
            $table->decimal('waiting_charge', 8, 2)->nullable();
            $table->string('car_brand');
            $table->string('car_model');
            $table->string('vehicle_type');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
}
