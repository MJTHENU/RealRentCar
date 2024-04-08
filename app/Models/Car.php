<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'vehicle_type',
        'brand',
        'model',
        'engine',
        'quantity',
        'seat',
        'price_per_km',
        'price_per_hr',
        'price_per_day',
        'reduce',
        'stars',
        'luggage',
        'ac',
        'image',
        'insurance_status',
        'status',
        'approval',
        'vehicle_id',
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
        
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }
}
