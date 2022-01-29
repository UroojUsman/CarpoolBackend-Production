<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'start_date',
        'start_time',
        'D_source_Long',
        'D_source_Lat',
        'D_dest_Long',
        'D_dest_Lat',
        'total_fare',
        'available_seats'
    ];

    
}
