<?php
use App\Http\Controllers\Api\AirplaneController;
use App\Http\Controllers\booking_Info_Qr_Controller;
use App\Http\Controllers\Api\checkuer;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\loging\login;
use App\Http\Controllers\Api\loging\ForgetAndRestPass;
use App\Http\Controllers\Api\loging\SocialiteLog;
use App\Http\Controllers\Api\loging\VerifyEmailController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
//_____________________________________________________________________________________________________________________//
Route::get('/for[Auth:api]',function(){return response()->json(['Message' => 'you shoud login','status'=>0], 400);})->name('not_logging');
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

Route::controller(RestaurantController::class)->group(function(){

    Route::middleware(['auth:api'])->group(function () {
        Route::post ('/addRestaurant',              'addRestaurant'              );
        Route::post ('/AcceptResturant',            'AcceptResturant'            )->middleware('admin');
        Route::post ('/RefusResturant',             'RefusResturant'             )->middleware('admin');
        Route::post ('/ShowAllResturants',          'ShowAllResturants'          );
        Route::post ('/Show_Not_Active_Resturants', 'Show_Not_Active_Resturants' )->middleware('admin');
        Route::post ('/add_Restaurant_Booking',     'add_Restaurant_Booking'     );
    });
});
//_____________________________________________________________________________________________________________________//
//Hotel
Route::controller(HotelController::class)->group(function(){

    Route::middleware(['auth:api'])->group(function () {
        Route::post ('/addHotel',                 'addHotel'              );
        Route::post ('/AcceptHotel',              'AcceptHotel'           )->middleware('admin');
        Route::post ('/RefusHotel',               'RefusHotel'            )->middleware('admin');
        Route::post ('/ShowAllHotels',            'ShowAllHotels'         );
        Route::post ('/Show_Not_Active_Hotels',   'Show_Not_Active_Hotels')->middleware('admin');
        Route::post ('/add_Hotel_Booking',        'add_Hotel_Booking'     );
    });
});
//_____________________________________________________________________________________________________________________//
//Airplane
Route::controller(AirplaneController::class)->group(function(){

    Route::middleware(['auth:api'])->group(function () {
        Route::post ('/addAirplane',                'addAirplane'               );
        Route::post ('/AcceptAirplane',             'AcceptAirplane'            )->middleware('admin');
        Route::post ('/RefusAirplane',              'RefusAirplane'             )->middleware('admin');
        Route::post ('/ShowAllAirplane',            'ShowAllAirplane'           );
        Route::post ('/Show_Not_Active_Airplanes',  'Show_Not_Active_Airplanes' )->middleware('admin');
        Route::post ('/add_Airplane_Booking',       'add_Airplane_Booking'      );
    });
});
//_____________________________________________________________________________________________________________________//
//Place
Route::controller(PlaceController::class)->group(function(){

    Route::middleware(['auth:api'])->group(function () {
        Route::post ('/addPlace',                'addPlace'               );
        Route::post ('/AcceptPlace',             'AcceptPlace'            )->middleware('admin');
        Route::post ('/RefusPlace',              'RefusPlace'             )->middleware('admin');
        Route::post ('/ShowAllPlaces',           'ShowAllPlaces'          );
        Route::post ('/Show_Not_Active_Places',  'Show_Not_Active_Places' )->middleware('admin');
    });
});
//_____________________________________________________________________________________________________________________//
//Package
Route::controller(PackageController::class)->group(function(){

    Route::middleware(['auth:api'])->group(function () {
    Route::post ('/addPackage'              ,'addPackage'             )->middleware('admin');
    Route::post ('/addFaciliticsToPackage'  ,'addFaciliticsToPackage' )->middleware('admin');
    Route::get  ('/get_Packages'            ,'get_Packages'           );
    Route::post ('/add_Package_Booking'     ,'add_Package_Booking'    );
    });
});
//_____________________________________________________________________________________________________________________//
//User
Route::prefix('user')->controller(UserController::class)->group(function(){

    Route::middleware(['auth:api','admin'])->group(function () {
        Route::get('/getAll','getAll');
        Route::get('/getNew','getNewUser');
        Route::get('/getOwner','getOwner');
        Route::get('/getAdmins','getAdmins');
        Route::get('/getUsers','getUsers');
        Route::get('/UnActive','UnActive');  
        Route::post('/PromotionToAdmin','PromotionToAdmin');
        Route::post('/DemotionToUser','DemotionToUser')->withoutMiddleware('admin')->middleware('owner');
        Route::post('/Block','Block');
        Route::post('/Delete','Delete');
      });
});
//_____________________________________________________________________________________________________________________//

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::post('/checkuer' ,   [checkuer ::class, 'check'      ])->middleware(['auth:api'])->middleware('checkuser');
Route::post('/nameByToken' ,[checkuer ::class, 'nameByToken'])->middleware(['auth:api']);
Route::get('/qr/{id}/{bookingid}',[booking_Info_Qr_Controller::class,'show']);
