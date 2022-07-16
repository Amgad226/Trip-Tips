<?php
use App\Http\Controllers\Api\AirplaneController;
use App\Http\Controllers\Api\CategoryController;
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
// Get category and TouristSupervisor
Route::controller(CategoryController::class)->group(function(){

    Route::middleware(['auth:api','admin'])->group(function () {
        Route::get ('/getRestaurantCategory',    'getRestaurantCategory'     );
        Route::get ('/getHotelCategory',         'getHotelCategory'          );
        Route::get ('/getPackageCategory',       'getPackageCategory'        );
        Route::get ('/getTouristSupervisor',        'getTouristSupervisor'         );
    });
});
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

        Route::post ('/add_Restaurant_Comment',     'add_Restaurant_Comment'     );
        Route::post ('/remove_Restaurant_Comment',     'remove_Restaurant_Comment'     );
        Route::post ('/Show_Restaurant_Comments',     'Show_Restaurant_Comments'     );
        Route::post ('/Show_Restaurant_Comment',     'Show_Restaurant_Comment'     );
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

        Route::post ('/add_Hotel_Comment',        'add_Hotel_Comment'     );
        Route::post ('/remove_Hotel_Comment',        'remove_Hotel_Comment'     );
        Route::post ('/Show_Hotel_Comments',        'Show_Hotel_Comments'     );
        Route::post ('/Show_Hotel_Comment',        'Show_Hotel_Comment'     );

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
   
        Route::post ('/add_Airplane_Comment',       'add_Airplane_Comment'      );
        Route::post ('/remove_Airplane_Comment',       'remove_Airplane_Comment'      );
        Route::post ('/Show_Airplane_Comments',       'Show_Airplane_Comments'      );
        Route::post ('/Show_Airplane_Comment',       'Show_Airplane_Comment'      );
        
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

        Route::post ('/add_Place_Comment',           'add_Place_Comment'          );
        Route::post ('/remove_Place_Comment',           'remove_Place_Comment'          );
        Route::post ('/Show_Place_Comments',           'Show_Place_Comments'          );
        Route::post ('/Show_Place_Comment',           'Show_Place_Comment'          );

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
    Route::post ('/ِAddTouristSupervisor'     ,'ِAddTouristSupervisor'  )->middleware('admin');
    Route::post ('/DeleteTouristSupervisor'  ,'DeleteTouristSupervisor')->middleware('admin');
        
    Route::post ('/add_Package_Comment'     ,'add_Package_Comment'    );
    Route::post ('/remove_Package_Comment'     ,'remove_Package_Comment'    );
    Route::post ('/Show_Package_Comments'     ,'Show_Package_Comments'    );
    Route::post ('/Show_Package_Comment'     ,'Show_Package_Comment'    );
    
    
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
        Route::post('/unBlock','unBlock');
        Route::post('/Delete','Delete');
      });
      Route::post('addCommentForApp',     'addCommentForApp'       )->middleware(['auth:api']);
      Route::post('addCommentForApp',     'addCommentForApp'       )->middleware(['auth:api']);
      Route::post('Show_Comments_For_App','Show_Comments_For_App'  )->middleware(['auth:api']);
      Route::post('Show_Comment_For_App', 'Show_Comment_For_App'   )->middleware(['auth:api']);
});
//_____________________________________________________________________________________________________________________//
Route::get('/booking-info/{id}/{token}/{bookingid}/{unique}',[booking_Info_Qr_Controller::class,'show']);
//_____________________________________________________________________________________________________________________//

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::post('/checkuer' ,   [checkuer ::class, 'check'      ])->middleware(['auth:api'])->middleware('checkuser');
Route::post('/nameByToken' ,[checkuer ::class, 'nameByToken'])->middleware(['auth:api']);
// Route::get('/qr/{id}/{bookingid}',[booking_Info_Qr_Controller::class,'show']);
// Route::get('/booking-info/{id}/{bookingid}',[booking_Info_Qr_Controller::class,'show']);
