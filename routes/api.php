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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/OtpVerification',[SmsController::class,'VerifyOtp']);
Route::post('/ResendOtp',[SmsController::class,'ResendOtp']);

Route::put('/updateProfile/{id}',[AuthController::class,'updateProfile']);
Route::post('/createDriver',[DriverController::class,'createDriver']);
Route::post('/updateDriver',[DriverController::class,'updateDriver']);
Route::get('/AllDriver',[DriverController::class,'AllDriver']);
Route::post('/createRider',[RiderController::class,'createRider']);
Route::post('/addRequest',[RequestController::class,'addRequest']);


Route::group(['middleware'=>['auth:sanctum']],function(){

    Route::post('/logout',[AuthController::class,'logout']);
    // Route::post('/updateProfile',[AuthController::class,'updateProfile']);
    // Route::post('/createDriver',[DriverController::class,'createDriver']);
    // Route::post('/updateDriver',[DriverController::class,'updateDriver']);
    // Route::get('/AllDriver',[DriverController::class,'AllDriver']);

    
});