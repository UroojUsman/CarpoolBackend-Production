<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderTripHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'rider_user_id',
        'driver_name',
        'start_datetime',
        'end_datetime',
        'source_address',
        'dest_address',
        'fare',
        'status'
    ];


    protected $table = 'rider_trip_history';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
