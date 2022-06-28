<?php

use App\Http\Controllers\add;
use App\Http\Controllers\Api\auth\log;
use App\Http\Controllers\API\log as APILog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Airplane;
use App\Models\BookingAirplane;
use App\Models\BookingHotel;
use App\Models\BookingPackage;
use App\Models\BookingRestaurant;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Restaurant;

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
Route::post ('/addRestaurant',         [add::class,  'addRestaurant'          ] );
Route::post ('/addHotel',              [add::class,  'addHotel'               ] );
Route::post ('/addAirplane',           [add::class,  'addAirplane'            ] );
Route::post ('/addPackage',            [add::class,  'addPackage'             ] );
Route::post ('/add_Restaurant_Booking',[add::class,  'add_Restaurant_Booking' ] );
Route::post ('/add_Hotel_Booking',     [add::class,  'add_Hotel_Booking'] );
Route::post ('/add_Airplane_Booking',  [add::class,  'add_Airplane_Booking'   ] );
Route::post ('/add_Package_Booking',   [add::class,  'add_Package_Booking'    ] );


Route::post('/register' ,         [APILog::class, 'register'            ]);
