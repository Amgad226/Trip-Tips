<?php

// use App\Http\Controllers\Api\AddPlace;

use App\Http\Controllers\Api\AddPlace;
use App\Http\Controllers\Api\AirplaneController;
use App\Http\Controllers\Api\checkuer;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\loging\login;
use App\Http\Controllers\Api\loging\ForgetAndRestPass;
use App\Http\Controllers\Api\loging\SocialiteLog;
use App\Http\Controllers\Api\loging\VerifyEmailController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\RestaurantController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
//_____________________________________________________________________________________________________________________//
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});
Route::get('/for-middelwarer[Auth:api]-transfare-to-login-route-in-web-she-transfare-to-this-error-messaage', function () {
    return response()->json(['Message' => 'you shoud login to use this route [middelwere->route]'], 400);})->name('not_logging');
    

Route::post('/checkuer' ,            [checkuer                ::class, 'check'     ])->middleware(['auth:api'])->middleware('checkuser');







//NOTE add fun groupe middelware to routes have the same middelware 
//_____________________________________________________________________________________________________________________//
//Loging Routes
Route::post('/register' ,          [login                ::class, 'register'          ] );
Route::post('/login' ,             [login                ::class, 'login'             ] );
Route::post('/token' ,             [login                ::class, 'token'             ] );
Route::post('/logout' ,            [login                ::class, 'logout'            ] )->middleware(['auth:api']);
    
Route::post('/forgot' ,            [ForgetAndRestPass    ::class, 'forgot'            ] );
Route::post('/reset' ,             [ForgetAndRestPass    ::class, 'reset'             ] );
Route::post('/checkToken' ,        [ForgetAndRestPass    ::class, 'checkToken'        ] );
    
Route::post('/send_notification',  [VerifyEmailController::class, 'resend'            ] )->middleware(['auth:api']);
Route::get ('/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'            ] )->middleware(['signed'  ])->name('verify');
Route::post ('/Verify_checking',   [VerifyEmailController::class, 'Verify_checking'   ] )->middleware(['auth:api']);
    
Route::post('registerSocialite',   [SocialiteLog::class, 'registerSocialite'          ] );
Route::post('addPasswordSocialite',[SocialiteLog::class, 'addPasswordSocialite'       ] )->middleware(['auth:api']);
//_____________________________________________________________________________________________________________________//
//Restaurant
Route::post ('/addRestaurant',         [RestaurantController::class,  'addRestaurant'    ] )->middleware(['auth:api']);
   
Route::post ('/AcceptResturant',       [RestaurantController::class,  'AcceptResturant'  ] )->middleware(['auth:api'])->middleware('admin');
   
Route::post ('/RefusResturant',        [RestaurantController::class,  'RefusResturant'   ] )->middleware(['auth:api'])->middleware('admin');
   
Route::post ('/ShowAllResturants',     [RestaurantController::class,  'ShowAllResturants'] )->middleware(['auth:api']);
   
// Route::post ('/ShowResturant',         [RestaurantController::class,  'ShowResturant'    ] )->middleware(['auth:api']);

Route::post ('/add_Restaurant_Booking',[RestaurantController::class,'add_Restaurant_Booking' ] )->middleware(['auth:api']);
//_____________________________________________________________________________________________________________________//
//Hotel
Route::post ('/addHotel',              [HotelController::class,  'addHotel'          ] )->middleware(['auth:api']);

Route::post ('/AcceptHotel',           [HotelController::class,  'AcceptHotel'       ] )->middleware(['auth:api'])->middleware('admin');

Route::post ('/RefusHotel',            [HotelController::class,  'RefusHotel'        ] )->middleware(['auth:api'])->middleware('admin');

Route::post ('/ShowAllHotels',         [HotelController::class,  'ShowAllHotels'     ] )->middleware(['auth:api']);

Route::post ('/add_Hotel_Booking',     [HotelController::class,  'add_Hotel_Booking' ] )->middleware(['auth:api']);

//_____________________________________________________________________________________________________________________//
//Airplane
Route::post ('/addAirplane',           [AirplaneController::class,  'addAirplane'            ] )->middleware(['auth:api']);

Route::post ('/AcceptAirplane',        [AirplaneController::class,  'AcceptAirplane'         ] )->middleware(['auth:api'])->middleware('admin');

Route::post ('/RefusAirplane',         [AirplaneController::class,  'RefusAirplane'          ] )->middleware(['auth:api'])->middleware('admin');

Route::post ('/ShowAllAirplane',       [AirplaneController::class,  'ShowAllAirplane'        ] )->middleware(['auth:api']);

Route::post ('/add_Airplane_Booking',  [AirplaneController::class,  'add_Airplane_Booking'   ] )->middleware(['auth:api']);
//_____________________________________________________________________________________________________________________//
//Package
Route::post ('/addPackage',            [PackageController::class,  'addPackage'             ] )->middleware(['auth:api'])->middleware('admin');

Route::post ('/addFaciliticsToPackage',[PackageController::class,  'addFaciliticsToPackage' ] )->middleware(['auth:api'])->middleware('admin');

Route::get  ('/get_Packages',          [PackageController::class,  'get_Packages'    ] );

Route::post ('/add_Package_Booking',   [PackageController::class,  'add_Package_Booking'    ] )->middleware(['auth:api']);
