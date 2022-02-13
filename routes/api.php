<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\RequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class,'register']); //tested
Route::post('/login',[AuthController::class,'login']); //tested
Route::post('/OtpVerification',[SmsController::class,'VerifyOtp']); //tested
Route::post('/ResendOtp',[SmsController::class,'ResendOtp']); //tested

Route::post('/updateProfile',[AuthController::class,'updateProfile']); //tested
Route::post('/createDriver',[DriverController::class,'createDriver']); //tested
Route::post('/updateDriver',[DriverController::class,'updateDriver']);  //tested
Route::get('/AllDriver',[DriverController::class,'AllDriver']); //tested
Route::post('/AcceptRequest',[DriverController::class,'AcceptRequest']); //tested
Route::post('/StartRide',[DriverController::class,'StartRide']); //tested
Route::post('/EndtRide',[DriverController::class,'EndRide']);
//Route::post('/StartRide',[DriverController::class,'StartRide']);


Route::post('/createRider',[RiderController::class,'createRider']); //tested
Route::post('/updateRider',[RiderController::class,'updateRider']); //tested
// Route::post('/addRequest',[RequestController::class,'addRequest']);
Route::get('/allRider',[RiderController::class,'allRider']); //tested
Route::post('/ShowAllRidersToDriver',[RiderController::class,'ShowAllRidersToDriver']); //tested


Route::group(['middleware'=>['auth:sanctum']],function(){

    Route::post('/logout',[AuthController::class,'logout']);
    // Route::post('/updateProfile',[AuthController::class,'updateProfile']);
    // Route::post('/createDriver',[DriverController::class,'createDriver']);
    // Route::post('/updateDriver',[DriverController::class,'updateDriver']);
    // Route::get('/AllDriver',[DriverController::class,'AllDriver']);

    
});