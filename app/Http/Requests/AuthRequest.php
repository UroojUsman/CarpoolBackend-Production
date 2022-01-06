<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\GuestUser;
use App\Services\SmsService;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    protected $SmsService;

    public function __construct(SmsService $SmsService)
    {
        $this->SmsService = $SmsService;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['required','string'],
            'phone'=>['required','unique:users','min:13'],
            'email'=>['required','email','string','unique:users'],
            'password'=>['required','string','confirmed']
        ];
    }

    public function store()
    {   
        $user= new User;
        //$guest= new GuestUser;
        $userRow= $user->where('phone',$this->validated('phone'))->first();
        if($userRow)
        {
            return response([
                'message'=>'User Already Registered',
                'code'=>401
            ],401);
        }
        else{
            $guestuser= GuestUser::create($this->validated());
            $send= $this->SmsService->SendSms($guestuser->id);
            if($send)
            {
                return response([
                    'message'=>'SMS sent',
                    'guest'=>$guestuser,
                    'code'=>202
                ],202);
            }
            else{
                return response([
                    'message'=>'SMS not sent',
                    'guest'=>$guestuser,
                    
                ],401);
            }
            
        }
        //return User::create($this->validated());
    }
}
