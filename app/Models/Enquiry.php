<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'mobile_no',
        'start_date',
        'end_date',
        'start_loc',
        'end_loc',
        'seat',
        'luggage', // Corrected field name
        'vehicle_type',
        'AC',
        'desc',
        'journey_type',
    ];

    protected $casts = [
        'AC' => 'string',
    ];
}
