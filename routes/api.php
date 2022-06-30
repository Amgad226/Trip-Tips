<?php

use App\Http\Controllers\add;
use App\Http\Controllers\Api\loging\login;
use App\Http\Controllers\Api\loging\ForgetAndRestPass;
use App\Http\Controllers\Api\loging\VerifyEmailController;
use Illuminate\Support\Facades\Route;
//_____________________________________________________________________________________________________________________//


//loging Routes
//NOTE add fun groupe middelware to routes have the same middelware 
Route::post('/register' ,         [login                ::class, 'register']);
Route::post('/login' ,            [login                ::class, 'login'   ]);
Route::post('/logout' ,           [login                ::class, 'logout'  ])->middleware(['auth:api']);
Route::post('/forgot' ,           [ForgetAndRestPass    ::class, 'forgot'  ]);
Route::post('/reset' ,            [ForgetAndRestPass    ::class, 'reset'   ]);
Route::post('/send_notification', [VerifyEmailController::class, 'resend'  ])->middleware(['auth:api'])->name('verification.send');
Route::get ('/verify/{id}/{hash}',[VerifyEmailController::class, 'verify'  ])->middleware(['signed'  ])->name('verification.verify');

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
