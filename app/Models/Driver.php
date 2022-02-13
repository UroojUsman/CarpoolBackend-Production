<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'start_datetime',
        'end_datetime',
        'D_source_Long',
        'D_source_Lat',
        'D_source_address',
        'D_dest_Long',
        'D_dest_Lat',
        'D_dest_address',
        'total_fare',
        'available_seats',
        'occupied_seats',
        'total_seats',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
