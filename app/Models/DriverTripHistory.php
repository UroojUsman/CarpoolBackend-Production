<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverTripHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_user_id',
        'start_datetime',
        'end_datetime',
        'source_address',
        'dest_address',
        'fare',
        'total_passengers',
        'status'
    ];

    protected $table = 'driver_trip_history';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
