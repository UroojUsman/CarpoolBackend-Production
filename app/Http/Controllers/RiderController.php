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
}
