<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addreqRequest;
use App\Models\Ride_Request;

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
        $reqs= Ride_Request::where('driver_id',$request->driver_id)->get();
        foreach($req as $reqs)
        {
            $rider[]=$req->rider;
        }

        return $rider;
    }

}
