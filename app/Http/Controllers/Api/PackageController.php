<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AcceptFacilities;
use App\Models\Airplane\Airplane;
use App\Models\Airplane\AirplaneBooking;
use App\Models\Airplane\AirplaneRole;
use App\Models\Restaurant\RestaurantBooking;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantImage;
use App\Models\Restaurant\RestaurantRole;

use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelImages;
use App\Models\Hotel\HotelBooking;
use App\Models\Hotel\HotelRole;

use App\Models\Package\Package;
use App\Models\Package\PackageBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use  Image;

class PackageController extends Controller
{


    public function addPackage(Request $request)
    {
         $data = [
             'name'             => $request->name,
             'hotel_id'            => $request->hotel_id,
             'airplane_id'         => $request->airplane_id,
             'restaurant_id'       => $request->restaurant_id,
            ];
            // dd(($data));
            // dd($request->hotel_id); 
         $Package = Package::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Package added successfully',
             'item'=>$Package,
         ]);     
    }

   


    public function add_Package_Booking(Request $request)
    {
         $data = [
             'package_id'             => $request->Package_id,
             'user_id'             => $request->user_id,
            ];
            
            $Booking = PackageBooking::with('package')->where('id',1)->first();


            $data_to_restaurant = [
                'restaurant_id'             => $Booking->package->restaurant->id,
                'user_id'             => $request->user_id,
               ];
               RestaurantBooking::create($data_to_restaurant);
            // dd()
            // $Book_in_restaurant::cerate()
            // dd($Booking->package->airplane->name_en);
            // dd($Booking->package->restaurant->id);

            $BookingPackage = PackageBooking::create($data);
         //  dd($BookingPackage);
        //  dd($BookingPackage->package->name_EN); 
         $airplane = new Airplane;
         return response()->json([
             'status' => '1',
             'message' => 'Booking Package  added successfully',
             'item'=>$BookingPackage,
         ]);     
    }
}
