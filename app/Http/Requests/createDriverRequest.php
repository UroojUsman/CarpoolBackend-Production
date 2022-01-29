<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Driver;

class createDriverRequest extends FormRequest
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
            'start_date'=>['required'],
            'start_time'=>['required'],
            'D_source_Long'=>['required'],
            'D_source_Lat'=>['required'],
            'D_dest_Long'=>['required'],
            'D_dest_Lat'=>['required'],
            'total_fare'=>['required'],
            'available_seats'=>['required'],
            // 'rider_1'=>['nullable'],
            // 'rider_2'=>['nullable'],
            // 'rider_3'=>['nullable'],
            
        ];
    }

    public function store()
    {
        $driver= Driver::create($this->validated());
        if($driver)
        {
            return response([
                'message'=>'Ride Offered',
                'driver_id'=>$driver,
                'code'=>202
            ],202);
        }
        else{
            return response([
                'message'=>'Ride Offer declined'
                
            ]);
        }
            
    }


}
