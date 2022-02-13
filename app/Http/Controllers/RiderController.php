<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addRiderRequest;
use App\Models\Rider;

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
}
