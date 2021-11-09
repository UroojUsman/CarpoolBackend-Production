<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Otp;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Http\Response;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
 {

    protected $SmsService;

    public function __construct(SmsService $SmsService)
    {
        $this->SmsService = $SmsService;
    }

    public function VerifyOtp(Request $req)
    {
        $Otp = new Otp;
        $user = new User;
        $userEntry = $user->where('id',$req->id)->first();
       $code= $Otp->where('user_id',$req->id)->first();
       $Otpid = $code->id;
       if($req->Otp === $code->Otp)
       {
           $token = $userEntry->createToken('myappToken')->plainTextToken;
           $code->delete($Otpid);
           
           return response([
            'message'=>'token generated successfully',
            'token'=>$token
           ],201);
       }
       else{
        $code->delete($Otpid);
        return response([
            'message'=>'Invalid Otp'
           ],401);
       }

    }

    public function ResendOtp(Request $req)
    {
       $this->SmsService->SendSms($req->id);
        // SmsController::SendSms($req->id);
        return $send;
    }
}
