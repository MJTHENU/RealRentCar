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
        Schema::create('cars', function (Blueprint $table) {
$table->id();
$table->string('email_id')->nullable();
$table->string('vehicle_id')->nullable();
$table->string('brand');
$table->string('model');
$table->string('engine');
$table->integer('seat')->nullable();
$table->integer('luggage')->nullable();
$table->enum('ac', ['yes', 'no'])->default('no');
$table->enum('approval', ['pending', 'confirm'])->default('pending');
$table->enum('vehicle_type' , ['car', 'van', 'bus'])->default('car');
$table->decimal('price_per_km', 8, 2)->nullable();
$table->decimal('price_per_hr', 8, 2)->nullable();
$table->decimal('price_per_day', 8, 2)->nullable();
$table->string('image')->nullable();
$table->string('quantity');
$table->enum('insurance_status', ['pending', 'active','expired'])->default('pending');
$table->string('status')->default('available');
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
