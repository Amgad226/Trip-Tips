<?php

// use App\Http\Controllers\Api\AddPlace;

use App\Http\Controllers\Api\AddPlace;
use App\Http\Controllers\Api\checkuer;
use App\Http\Controllers\Api\loging\login;
use App\Http\Controllers\Api\loging\ForgetAndRestPass;
use App\Http\Controllers\Api\loging\SocialiteLog;
use App\Http\Controllers\Api\loging\VerifyEmailController;
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








//loging Routes
//NOTE add fun groupe middelware to routes have the same middelware 
Route::post('/register' ,          [login                ::class, 'register'   ]);
Route::post('/login' ,             [login                ::class, 'login'      ]);
Route::post('/logout' ,            [login                ::class, 'logout'     ])->middleware(['auth:api']);


Route::post('/forgot' ,            [ForgetAndRestPass    ::class, 'forgot'     ]);
Route::post('/reset' ,             [ForgetAndRestPass    ::class, 'reset'      ]);
Route::post('/checkToken' ,        [ForgetAndRestPass    ::class, 'checkToken'      ]);

Route::post('/send_notification',  [VerifyEmailController::class, 'resend'     ])->middleware(['auth:api']);
Route::get ('/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'     ])->middleware(['signed'  ])->name('verify');
Route::post ('/Verify_checking',   [VerifyEmailController::class, 'Verify_checking'])->middleware(['auth:api']);

Route::post('registerSocialite',  [SocialiteLog::class, 'registerSocialite'  ]);
Route::post('addPasswordSocialite',[SocialiteLog::class, 'addPasswordSocialite'])->middleware(['auth:api']);
//_____________________________________________________________________________________________________________________//
//Adding places in dashbord 
Route::post ('/addRestaurant',      [AddPlace::class,  'addRestaurant'    ] )->middleware(['auth:api']);

Route::post ('/AcceptResturant',    [AddPlace::class,  'AcceptResturant'  ] )->middleware(['auth:api'])->middleware('checkuser')->middleware('admin');

Route::post ('/RefusResturant',     [AddPlace::class,  'RefusResturant'   ] )->middleware(['auth:api'])->middleware('checkuser')->middleware('admin');

Route::post ('/ShowResturant',      [AddPlace::class,  'ShowResturant'    ] );//->middleware(['auth:api'])->middleware('checkuser')->middleware('supervisor_restaurant');
Route::post ('/ShowAllResturants',  [AddPlace::class,  'ShowAllResturants'] );//->middleware(['auth:api'])->middleware('checkuser')->middleware('supervisor_restaurant');






Route::post ('/addHotel',              [AddPlace::class,  'addHotel'               ] )->middleware(['auth:api']);
Route::post ('/addAirplane',           [AddPlace::class,  'addAirplane'            ] )->middleware(['auth:api']);






Route::post ('/addPackage',            [AddPlace::class,  'addPackage'             ] );

//add Booking to places in flutter
Route::post ('/add_Restaurant_Booking',[AddPlace::class,  'add_Restaurant_Booking' ] );
Route::post ('/add_Hotel_Booking',     [AddPlace::class,  'add_Hotel_Booking'      ] );
Route::post ('/add_Airplane_Booking',  [AddPlace::class,  'add_Airplane_Booking'   ] );
Route::post ('/add_Package_Booking',   [AddPlace::class,  'add_Package_Booking'    ] );
