<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Otp extends Model
{
    use HasFactory ;

    protected $fillable=['user_id','Otp'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
