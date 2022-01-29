<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Driver;

class updateDriverRequest extends FormRequest
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
            'id'=>['required'],
            'start_date'=>['required'],
            'start_time'=>['required'],
            'D_source_Long'=>['required'],
            'D_source_Lat'=>['required'],
            'D_dest_Long'=>['required'],
            'D_dest_Lat'=>['required'],
            'total_fare'=>['required'],
            'available_seats'=>['required']
        ];
    }

    public function update()
    {
        return $this->validated();
        // $driver= Driver::where('id',$id)->first();
       
       
        // $driver->start_date= $this->validated('start_date');
        // $driver->start_time = $this->validated('start_time');
        // $driver->D_source_Long = $this->validated('D_source_Long');
        // $driver->D_source_Lat = $this->validated('D_source_Lat');
        // $driver->D_dest_Long = $this->validated('D_dest_Long');
        // $driver->D_dest_Lat = $this->validated('D_dest_Lat');
        // $driver->total_fare= $this->validated('total_fare');
        // if($driver->save())
        // {
        //     return response([
        //         'message'=>'Ride details Updated',
        //         'updated_Driver'=>$driver,
        //         'code'=>202
        //     ]);
        // }
        // else{
        //     return response([
        //         'message'=>'ride not updated',
        //         'driver'=>$driver,
                
        //     ]);
        // }
     }
}
