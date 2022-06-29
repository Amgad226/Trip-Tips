<?php

use App\Http\Controllers\add;
use App\Http\Controllers\Api\loging\login;
use App\Http\Controllers\Api\loging\ForgetAndRestPass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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


Route::post('/register' ,         [login::class, 'register'            ]);
Route::post('/login' ,         [login::class, 'login'            ]);


Route::middleware("auth:api")->group( function(){

Route::post('/logout' ,         [login::class, 'logout'            ]);
    
Route::post('/forgot' ,        [ForgetAndRestPass::class, 'forgot']);
Route::post('/reset' ,         [ForgetAndRestPass::class, 'reset']);
});