<?php

use App\Http\Controllers\add;
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

//loging Routes
//NOTE add fun groupe middelware to routes have the same middelware 
Route::post('/register' ,          [login                ::class, 'register'   ]);
Route::post('/login' ,             [login                ::class, 'login'      ]);
Route::post('/logout' ,            [login                ::class, 'logout'     ])->middleware(['auth:api']);

Route::get('/aa' ,            [ForgetAndRestPass    ::class, 'aa'     ]);

Route::post('/forgot' ,            [ForgetAndRestPass    ::class, 'forgot'     ]);
Route::post('/reset' ,             [ForgetAndRestPass    ::class, 'reset'      ]);

Route::post('/send_notification',  [VerifyEmailController::class, 'resend'     ])->middleware(['auth:api'])->name('verification.send');
Route::get ('/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'     ])->middleware(['signed'  ])->name('verification.verify');
Route::post ('/Verify_checking',   [VerifyEmailController::class, 'Verify_checking'])->middleware(['auth:api']);

Route::post('requestTokenGoogle',  [SocialiteLog::class, 'requestTokenGoogle'  ]);
Route::post('requestTokenFacebook',[SocialiteLog::class, 'requestTokenFacebook']);
Route::post('addPasswordSocialite',[SocialiteLog::class, 'addPasswordSocialite'])->middleware(['auth:api']);
//_____________________________________________________________________________________________________________________//
//Adding places in dashbord 
Route::post ('/addRestaurant',         [add::class,  'addRestaurant'          ] );
Route::post ('/addHotel',              [add::class,  'addHotel'               ] );
Route::post ('/addAirplane',           [add::class,  'addAirplane'            ] );
Route::post ('/addPackage',            [add::class,  'addPackage'             ] );

//add Booking to places in flutter
Route::post ('/add_Restaurant_Booking',[add::class,  'add_Restaurant_Booking' ] );
Route::post ('/add_Hotel_Booking',     [add::class,  'add_Hotel_Booking'      ] );
Route::post ('/add_Airplane_Booking',  [add::class,  'add_Airplane_Booking'   ] );
Route::post ('/add_Package_Booking',   [add::class,  'add_Package_Booking'    ] );
