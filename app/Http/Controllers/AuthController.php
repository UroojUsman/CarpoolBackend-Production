<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\AuthRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SmsController;
use App\Services\SmsService;

class AuthController extends Controller
{

    protected $SmsService;

    public function __construct(SmsService $SmsService)
    {
        $this->SmsService = $SmsService;
    }

    public function register(AuthRequest $request){

        $response= $request->store();
        return $response;
        //$send= $this->SmsService->SendSms($user->id);
        
    //     $response=[
    //         'user'=> $user
    //     ];

    // return response($response,/*Response::HTTP_CREATED*/201); 
    }

    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        return [
            'message'=>'Logged out'
        ];
    }

    public function login(Request $request){

        $field= $request->validate([
            'phone'=>['required','min:13'],
            'password'=>['required','string']
        ]);

        $user= User::where('phone',$field['phone'])->first();
        if(!$user || !Hash::check($field['password'],$user->password))
        {
            return [
                'message'=>'Invalid Phone Number/ Password'
            ];
        }
        $token =$user->createToken('myappToken')->plainTextToken;
        $response=[
            'user'=> $user,
            'token'=> $token
        ];

        return response($response,201); 
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'is_driver'=>'required',
            'cnic'=>'required',
            'car_name'=>'required',
            'car_number'=>'required'
        ]);
        if($validated['is_driver']!=0)
        {
            $user= User::where('id',$validated['id'])->first(); 
            $user->is_driver= $validated['is_driver'];
            $user->cnic = $validated['cnic'];
            $user->car_name = $validated['car_name'];
            $user->car_number = $validated['car_number'];
            $user->save();
            return response([
                        'message'=>'Profile Updated',
                        'user'=>$user,
                        'code'=>202
                    ]);
        }
        else{
            return response([
                         'message'=>'Driver Profile not updated'
                        ]);
        }
        // $response= $request->update();
        // return $response;
         return $validated;

    }
}
