<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\createDriverRequest;
use App\Http\Requests\createDriverRequest;
use App\Models\Driver;
use App\Models\Rider;
use App\Models\RiderTripHistory;
use App\Models\DriverTripHistory;

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
             'start_datetime' => 'required',
            //  'start_time' => 'required',
             'D_source_Long' => 'required',
             'D_source_Lat' => 'required',
             'D_source_address' => 'required',
             'D_dest_Long' => 'required',
             'D_dest_Lat' => 'required',
             'D_dest_address' => 'required',
             'total_fare' => 'required',
             'available_seats'=>'required'
        ]);
         $driver= Driver::where('id',$validated['id'])->first(); 
        $driver->start_datetime= $validated['start_datetime'];
        //$driver->start_time = $validated['start_time'];
        $driver->D_source_Long = $validated['D_source_Long'];
        $driver->D_source_Lat = $validated['D_source_Lat'];
        $driver->D_source_address = $validated['D_source_address'];
        $driver->D_dest_Long = $validated['D_dest_Long'];
        $driver->D_dest_Lat = $validated['D_dest_Lat'];
        $driver->D_dest_address = $validated['D_dest_address'];
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
    $drivers= Driver::all();
    $response=array();
    foreach($drivers as $driver)
    {
        $response[]=['driver_name'=>$driver->user->name,
                    'driver_car_name'=>$driver->user->car_name,
                    'driver_car_number'=>$driver->user->car_number,
                    'driver_phone'=>$driver->user->phone,
                    'driver_id'=> $driver->id,
                    'driver_user_id'=> $driver->user_id,
                    'start_datetime'=>$driver->start_datetime,
                    'D_source_Long'=>$driver->D_source_Long,
                    'D_source_Lat'=>$driver->D_source_Lat,
                    'D_source_address'=>$driver->D_source_address,
                    'D_dest_Long'=>$driver->D_dest_Long,
                    'D_dest_Lat'=>$driver->D_dest_Lat,
                    'D_dest_address'=>$driver->D_dest_address,
                    'total_fare'=>$driver->total_fare,
                    'available_seats'=>$driver->available_seats,
                    'status'=>$driver->status,
		    'booked_seats'=>$driver->booked_seats];
    }

    return  response([
        'data'=>$response   
    ]);
}
public function StartRide(Request $request)
{
    $validated = $request->validate([
        'id' => 'required',
        // 'driver_id' => 'required',
    ]);
    $driver= Driver::where('id',$validated['id'])->first();
    $driver->status='Started';
    $driver->save();
    $riders = Rider::select('id')->where('driver_id', '=',$validated['id'])->where('status', '=', 'Accepted')->get();
    foreach($riders as $rider)
    {
        $rider->status='Started';
        $rider->save();
    }
    return response([
        'driver'=>$driver,
        'riders'=>$riders   
    ]);

}


    

    public function EndRide(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'end_datetime'=>'required'
            // 'driver_id' => 'required',
        ]);

        $driver= Driver::where('id',$validated['id'])->first();
        $DriverTripHistory = new DriverTripHistory(); 
        $total_fare = $driver->total_fare;
        $occupied_seats= $driver->occupied_seats;
        $fare= $total_fare/$occupied_seats;
        // $driver->status='Completed';
        // $driver->save();
        // $riders = Rider::select('id')->where('driver_id', '=',$validated['id'])->where('status', '=', 'Started')->get();
           
            $DriverTripHistory->driver_user_id = $driver->user_id;
            $DriverTripHistory->driver_name = $driver->user->name;
            $DriverTripHistory->start_datetime = $driver->start_datetime;
            $DriverTripHistory->end_datetime = $validated['end_datetime'];
            $DriverTripHistory->source_address = $driver->D_source_address;
            $DriverTripHistory->dest_address = $driver->D_dest_address;
            $DriverTripHistory->fare = $occupied_seats;
            $DriverTripHistory->total_passengers = $driver->occupied_seats;
            $DriverTripHistory->status = "Completed";
            if($DriverTripHistory->save())
            {
                $driver->delete();
                return response([
                    'Message'=>"Ride Ended",
                    'DriverTripHistory'=>$DriverTripHistory   
                ]);
                
            }
            return response([
                'Message'=>"Error Occured",
                'DriverTripHistory'=>$DriverTripHistory   
            ]);

      

    }

    public function CancelOffer(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required'
            // 'driver_id' => 'required',
        ]);
        $driver= Driver::where('id',$validated->id)->first();
        

    }

    public function RejectRide(Request $request)
    {
        $validated = $request->validate([
            'rider_id' => 'required',
            'driver_id' => 'required',
        ]);
        $rider= Rider::where('id',$validated['rider_id'])->where('status','Pending')->delete();
        
            return response([
                'message'=>'Ride Rejected',     
            ]);
    }

    

    public function AcceptRequest(Request $request)
    {
        $validated = $request->validate([
            'rider_id' => 'required',
            'driver_id' => 'required',
        ]);

        $driver= Driver::where('id',$validated['driver_id'])->first();
        $rider= Rider::where('id',$validated['rider_id'])->where('status','Pending')->first();
        if($driver && $driver->available_seats>0 && $driver->booked_seats<$driver->available_seats)
        {
           
            $rider->status='Accepted';
            $driver->booked_seats = $driver->booked_seats +1;
            $driver->save();
            $rider->save();

            return response([
                'message'=>'rider accpeted',
                'driver'=>$driver,
                'riders'=>$rider 
                  
            ]);

        }
        else if($driver->available_seats == $driver->booked_seats)
        {
            return response([
                'message'=>'All seats are booked',
                'driver'=>$driver,
                'riders'=>$rider
                  
            ]);
        }

        return $request;
    }
}
