<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider_Request extends Model
{
    use HasFactory;

    protected $fillable=[
        'rider_id',
        'driver_id'
    ];
    protected $table = 'ride_request';

    public function rider(){
        return $this->belongsTo(Rider::class);
    }
}
