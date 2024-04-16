<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'driver_id',
        'start_loc',
        'end_loc',
        'start_date',
        'end_date',
        'start_hr',
        'end_hr',
        'start_km',
        'end_km',
        'extra_km',
        'extra_charge',
        'min_charge',
        'waiting_charge',
        'toll_charge',
        'other_charges',
        'total_amount',
        'payment_status',
        'status',
    ];
}
