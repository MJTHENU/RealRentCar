<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
    protected $table = 'tariff';

    protected $fillable = [
        'plan_name',
        'vehicle_type',
            'brand',
            'model',
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
        'status' => 'string', // assuming 'status' is a string enum
    ];
    
}
