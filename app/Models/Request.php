<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rider;

class Request extends Model
{
    use HasFactory;

    protected $fillable=[
        'rider_id',
        'driver_id'
    ];

    public function rider(){
        return $this->belongsTo(Rider::class);
    }
}
