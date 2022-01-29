<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'R_source_Long',
        'R_source_Lat',
        'R_dest_Long',
        'R_dest_Lat',
        'status'
    ];
}
