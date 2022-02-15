<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiderTripHistory;

class RiderTripHistoryController extends Controller
{
    public function showAllRiderTrips(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required'
            // 'driver_id' => 'required',
        ]);

        $trips = RiderTripHistory::where('user_id',$validated['user_id'])->get();
        return response([
            'allTrips'=>$trips 
        ]); 
    }
}
