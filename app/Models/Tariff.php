<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    protected $table = 'tariffs'; // Corrected table name to match the migration

    protected $fillable = [
        'plan_name',
        'vehicle_type',
        'car_brand', // Corrected field name to match the migration
        'car_model', // Corrected field name to match the migration
        'tariff_type',
        'price_per_km',
        'price_per_hr',
        'price_per_day',
        'max_km',
        'min_charge',
        'extra_km',
        'waiting_charge',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // No need for the extra space after 'string'
    ];
}
