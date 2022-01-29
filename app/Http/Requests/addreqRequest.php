<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Rider_Request;

class addreqRequest extends FormRequest
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
            'rider_id'=>['required'],
            'driver_id'=>['required']
        ];
    }

    public function store()
    {
        $req= Rider_Request::create($this->validated());
        if($req)
        {
            return response([
                'message'=>'Request Added',
                'request'=>$req,
                'code'=>202
            ]);
        }
        else{
            return response([
                'message'=>'Request not added'
                
            ]);
        }
    }
}

