<?php

namespace App\Services;

use App\Models\User;
use App\Models\Otp;
use Nexmo\Laravel\Facade\Nexmo;

class SmsService{
    public function SendSms($user_id)
    {
        $Otp= mt_rand(1000,9999);
        $user = new User;
        $OtpEntry= new Otp;
        $userEntry = $user->where('id',$user_id)->first();
        $OtpEntry->user_id= $user_id;
        $OtpEntry->Otp= $Otp;
        $OtpEntry->save();
        Nexmo::message()->send([
            'to'=>$userEntry->phone,
            'from'=> $userEntry->phone,
            'text' => 'your OTP is '.$Otp.' for verification'
        ]);

        return true;
    }
}