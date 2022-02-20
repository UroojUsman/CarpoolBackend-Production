<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addRiderRequest;
use App\Models\Rider;
use App\Models\Driver;
use App\Models\RiderTripHistory;

class RiderController extends Controller
{
    public function createRider(addRiderRequest $request)
    {
        $response= $request->store();
        return $response;
    }

    public function allRider()
    {
        return Rider::all();
    }

    public function ShowAllRidersToDriver(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required',
            // 'driver_id' => 'required',
        ]);

        $rider=array();
        $reqs= Rider::where('driver_id', '=',$validated['driver_id'])->where('status', '=', 'Pending')->get();
        foreach($reqs as $req)
        {
            $rider[]=['rider_id'=>$req->id,
                        'rider_name'=>$req->user->name,      
                        'rider_user_id'=>$req->user_id,
                        'R_source_Long'=>$req->R_source_Long,
                        'R_source_Lat'=>$req->R_source_Lat,
                        'R_source_address'=>$req->R_source_address,
                        'R_dest_Long'=>$req->R_dest_Long,
                        'R_dest_Lat'=>$req->R_dest_Lat,
                        'R_dest_address'=>$req->R_dest_address,
                        'status'=>$req->status];
        }

        return $rider;
    }
    public function ShowAllAcceptedRidersbyDriver(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required',
        ]);

        $rider=array();
        $reqs= Rider::where('driver_id', '=',$validated['driver_id'])->where('status', '=', 'Accepted')->get();
        foreach($reqs as $req)
        {
            $rider[]=['rider_id'=>$req->id,
                        'rider_name'=>$req->user->name,
                        'rider_phone'=>$req->user->phone,      
                        'rider_user_id'=>$req->user_id,
                        'R_source_Long'=>$req->R_source_Long,
                        'R_source_Lat'=>$req->R_source_Lat,
                        'R_source_address'=>$req->R_source_address,
                        'R_dest_Long'=>$req->R_dest_Long,
                        'R_dest_Lat'=>$req->R_dest_Lat,
                        'R_dest_address'=>$req->R_dest_address,
                        'status'=>$req->status];
        }

        return $rider;
    }        

    public function ShowRiderStatus(Request $request)
    {
        $validated = $request->validate([
            'rider_id' => 'required',
        ]);
        $rider=Rider::where('id', '=',$validated['rider_id'])->first();
        return response([
            'Rider_status'=>$rider->status
        ]);

    }

    public function ShowDriverDetailsByRiderID(Request $request)
    {
        $validated = $request->validate([
            'rider_id' => 'required'
        ]);
       
        $rider = Rider::where('id', '=',$validated['rider_id'])->where('status', '=', 'Accepted')->first();
        $response=[
            
            'rider_name'=>$rider->user->name,
            'R_source_Lat'=>$rider->R_source_Lat,
            'R_source_Long'=>$rider->R_source_Long,
            "R_source_address"=> $rider->R_source_address,
            "R_dest_Long"=> $rider->R_dest_Long,
            "R_dest_Lat"=> $rider->R_dest_Lat,
            "R_dest_address"=> $rider->R_dest_address,
            "R_status"=> $rider->status,
            'rider_phone'=>$rider->user->phone,
            'driver_name'=>$rider->driver->user->name,
            'driver_phone'=>$rider->driver->user->phone,
            'Driver_start_datetime'=>$rider->driver->start_datetime,
            'D_source_Long'=>$rider->driver->D_source_Long,
            'D_source_Lat'=>$rider->driver->D_source_Lat,
            'D_source_address'=>$rider->driver->D_source_address,
            'D_dest_Long'=>$rider->driver->D_dest_Long,
            'D_dest_Lat'=>$rider->driver->D_dest_Lat,
            'D_dest_address'=>$rider->driver->D_dest_address,
        ];
        
        if($rider)
        {
            return response([
                'response'=>$response,
                'code'=>202
            ]);

        }
        else{
            return response([
                'Message'=>'No accepted rides'
            ]);
        }

    }
        
    public function updateRider(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required',
             'id' => 'required',
             'R_source_Long'=>'required',
            'R_source_Lat'=>'required',
            'R_source_address'=>'required',
            'R_dest_Long'=>'required',
            'R_dest_Lat'=>'required',
            'R_dest_address'=>'required'
        ]);

        $rider= Rider::where('id',$validated['id'])->first(); 
        $rider->driver_id= $validated['driver_id'];
        $rider->R_source_Long= $validated['R_source_Long'];
        $rider->R_source_Lat= $validated['R_source_Lat'];
        $rider->R_source_address= $validated['R_source_address'];
        $rider->R_dest_Long= $validated['R_dest_Long'];
        $rider->R_dest_Lat= $validated['R_dest_Lat'];
        $rider->R_dest_address= $validated['R_dest_address'];
        
        //$driver->start_time = $validated['start_time'];
        
        if($rider->save())
        {
            return response([
                'message'=>'Rider details Updated',
                'updated_Rider'=>$rider,
                'code'=>202
            ]);
        }
        else{
            return response([
                'message'=>'rider not updated',
                'rider'=>$rider,
                
            ]);
    }
    }



    public function EndRiderRide(Request $request)
    {
        $validated = $request->validate([
                    'driver_id' => 'required',
                    'rider_id' => 'required',
                    'end_datetime' =>'required'
                ]);

        $rider = Rider::where('driver_id', '=',$validated->id)->where('status', '=', 'Started')->first();
        $driver = Driver::where('id',$validated['driver_id'])->first();
        $total_fare = $driver->total_fare;
        $occupied_seats =$driver->occupied_seats;
        $perPersonFare = $total_fare/$occupied_seats;
        $RiderTripHistory = new RiderTripHistory();
        $RiderTripHistory->rider_user_id = $rider->user_id;
        $RiderTripHistory->driver_name = $driver->user->name;
        $RiderTripHistory->start_datetime = $driver->start_datetime;
        $RiderTripHistory->end_datetime = $validated['end_datetime'];
        $RiderTripHistory->source_address = $rider->R_source_address;
        $RiderTripHistory->dest_address = $rider->R_dest_address;
        $RiderTripHistory->fare=$perPersonFare;
        $RiderTripHistory->status="Completed";
        if($RiderTripHistory->save())
        {
            $res=Rider::where('id',validated['rider_id'])->delete();
            return response([
                'message'=>"Ride Completed",
                'res'=>$res   
            ]);
        }

    }
}
