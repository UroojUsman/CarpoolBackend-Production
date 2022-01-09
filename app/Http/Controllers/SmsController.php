<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\GuestUser;
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
        $guestUser= new GuestUser;
         $user = new User;
        $guserEntry = $guestUser->where('id',$req->id)->first();
        $guserEntry= $guserEntry->toArray();
       $code= $Otp->where('user_id',$req->id)->first();
       $Otpid = $code->id;
       if($req->Otp === $code->Otp)
       {   $verifedUser= $user->create($guserEntry);
           $token = $verifedUser->createToken('myappToken')->plainTextToken;
            GuestUser::where('id',$req->id)->delete();
           $code->delete($Otpid);
           
           return response([
            'message'=>'token generated successfully',
            'user'=>$verifedUser,
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
       $Otp = new Otp;
       $code= $Otp->where('user_id',$req->id)->first();
       $Otpid = $code->id;
       $code->delete($Otpid);
       $send=$this->SmsService->SendSms($req->id);
       if($send)
       {
        return response([
            'message'=>'OTP sent'
           ],201); 
       }
       else{
        return response([
            'message'=>'OTP not sent'
           ]); 
       }
       
    }
}
