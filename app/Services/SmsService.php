<?php

namespace App\Services;

use App\Models\User;
use App\Models\GuestUser;
use App\Models\Otp;
use Nexmo\Laravel\Facade\Nexmo;

class SmsService{
    public function SendSms($user_id)
    {
        $Otp= mt_rand(1000,9999);
        $guestuser = new GuestUser;
        $OtpEntry= new Otp;
        $guserEntry = $guestuser->where('id',$user_id)->first();
        $OtpEntry->user_id= $guserEntry->id;
        $OtpEntry->Otp= $Otp;
        $OtpEntry->save();
        $status = Nexmo::message()->send([
            'to'=>$guserEntry->phone,
            'from'=> "UniRide",
            'text' => 'your OTP is '.$Otp.' for verification'
        ]);

        return $status;
    }
}