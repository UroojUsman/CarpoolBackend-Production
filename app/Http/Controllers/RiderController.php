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
