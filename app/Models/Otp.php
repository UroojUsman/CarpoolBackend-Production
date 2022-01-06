<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GuestUser;

class Otp extends Model
{
    use HasFactory ;

    protected $fillable=['user_id','Otp'];

    public function guestuser(){
        return $this->belongsTo(GuestUser::class);
    }

}
