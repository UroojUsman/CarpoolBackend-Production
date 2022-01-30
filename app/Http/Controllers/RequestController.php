<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addreqRequest;
use App\Models\Rider_Request;

class RequestController extends Controller
{
    public function addRequest(addreqRequest $request)
    {
        $response= $request->store();
        return $response;
    }

    public function showRequestsToDriver(Request $request)
    {
        $rider=array();
        $reqs= Rider_Request::where('driver_id',$request->driver_id)->get();
        foreach($reqs as $req)
        {
            $rider[]=['rider_name'=>$req->rider->user->name,
                        'rider_id'=>$req->rider->id,
                        'rider_user_id'=>$req->rider->user_id,
                        'R_source_Long'=>$req->rider->R_source_Long,
                        'R_source_Lat'=>$req->rider->R_source_Lat,
                        'R_dest_Long'=>$req->rider->R_dest_Long,
                        'R_dest_Lat'=>$req->rider->R_dest_Lat,
                        'status'=>$req->rider->status];
        }

        return $rider;
    }

}
