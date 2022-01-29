<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\createDriverRequest;
use App\Http\Requests\createDriverRequest;
use App\Http\Requests\updateDriverRequest;
use App\Models\Driver;

class DriverController extends Controller
{
    public function createDriver(createDriverRequest $request)
    {
        $response= $request->store();
        return $response;
     
    }

    public function updateDriver(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
             'start_date' => 'required',
             'start_time' => 'required',
             'D_source_Long' => 'required',
             'D_source_Lat' => 'required',
             'D_dest_Long' => 'required',
             'D_dest_Lat' => 'required',
             'total_fare' => 'required',
             'available_seats'=>'required'
        ]);
         $driver= Driver::where('id',$validated['id'])->first(); 
        $driver->start_date= $validated['start_date'];
        $driver->start_time = $validated['start_time'];
        $driver->D_source_Long = $validated['D_source_Long'];
        $driver->D_source_Lat = $validated['D_source_Lat'];
        $driver->D_dest_Long = $validated['D_dest_Long'];
        $driver->D_dest_Lat = $validated['D_dest_Lat'];
        $driver->total_fare= $validated['total_fare'];
        $driver->available_seats=$validated['available_seats'];
        if($driver->save())
        {
            return response([
                'message'=>'Ride details Updated',
                'updated_Driver'=>$driver,
                'code'=>202
            ]);
        }
        else{
            return response([
                'message'=>'ride not updated',
                'driver'=>$driver,
                
            ]);
      
       
        
    }
}


    public function AllDriver()
    {
        return Driver::all();
    }

    public function AcceptRequest(Request $request)
    {
        $validated = $request->validate([
            'rider_id' => 'required',
            'driver_id' => 'required',
        ]);

        $driver= Driver::where('driver_id',$validated->driver_id)->first();
        if($driver && $driver->available_seats>0 && $driver->available_seats<=3)
        {
            if(is_null($driver->R1))
            {
                $driver->R1=$validated->rider_id;
                $driver->available_seats = $driver->available_seats -1;
                $driver->save();
                
            }
            else if(is_null($driver->R2))
            {
                $driver->R2=$validated->rider_id;
                $driver->available_seats = $driver->available_seats -1;
                $driver->save();
            }
            else if(is_null($driver->R3))
            {
                $driver->R3=$validated->rider_id;
                $driver->available_seats = $driver->available_seats -1;
                $driver->save();
            }



        }
    }
}
