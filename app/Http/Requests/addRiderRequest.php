<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Rider;

class addRiderRequest extends FormRequest
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
            'user_id'=>['required'],
            'R_source_Long'=>['required'],
            'R_source_Lat'=>['required'],
            'R_dest_Long'=>['required'],
            'R_dest_Lat'=>['required']
        ];
    }

    public function store()
    {
        $rider= Rider::create($this->validated());
        if($rider)
        {
            return response([
                'message'=>'Rider Created',
                'rider'=>$rider,
                'code'=>202
            ]);
        }
        else{
            return response([
                'message'=>'Rider not created'
            ]);
        }

    }
}
