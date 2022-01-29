<?php

namespace App\Http\Requests;
use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    
        return [
            // 'name'=>['required','string'],
            // 'phone'=>['required','unique:users','min:13'],
            // 'email'=>['required','email','string','unique:users'],
            'is_driver'=>['required'],
            'cnic'=>['required_if:is_driver,==,true','min:13'],
            'car_number'=>['required_if:is_driver,==,true'],
            'car_name'=>['required_if:is_driver,==,true','string']
        ];
    }

    public function update($id){

        $user= User::where('id',$id)->first();
        //$user->is_driver= $this->validated('is_driver');
        $user->cnic = $this->validated('cnic');
        $user->car_name=$this->validated('car_name');
        $user->car_number=$this->validated('car_number');
        if($user->save())
        {
            return response([
                'message'=>'Profile Updated',
                'user'=>$user,
                'code'=>202
            ]);
        }
        else{
            return response([
                'message'=>'Profile not updated'
                        
            ]);
        }




    }
}
