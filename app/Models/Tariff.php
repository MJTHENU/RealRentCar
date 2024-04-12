<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======

>>>>>>> faebc6c74e55b14f682972a7772e1e51aae44f8c
    protected $table = 'tariff';

    protected $fillable = [
        'plan_name',
<<<<<<< HEAD
        'vehicle_type',
            'brand',
            'model',
        'tariff_type',
        
=======
        'tariff_type',
>>>>>>> faebc6c74e55b14f682972a7772e1e51aae44f8c
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
<<<<<<< HEAD
        'status' => 'string', // assuming 'status' is a string enum
    ];
    
}
=======
        'status' => 'string', // assuming 'status' is a string enum
    ];
}
>>>>>>> faebc6c74e55b14f682972a7772e1e51aae44f8c
