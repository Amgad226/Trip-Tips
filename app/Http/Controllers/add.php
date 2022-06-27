<?php

namespace App\Http\Controllers;

use App\Models\Airplane;
use App\Models\BookingAirplane;
use App\Models\BookingHotel;
use App\Models\BookingPackage;
use App\Models\BookingRestaurant;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class add extends Controller
{

    public function addRestaurant(Request $request)
    {
         $data = [
             'name_en'             => $request->name_en,
            ];
         $restaurant = Restaurant::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'restaurant added successfully',
             'item'=>$restaurant,
         ]);     
    }
//yass
//amgad 
    public function addHotel(Request $request)
    {
        // dd($request->name_en);

         $data = [
             'name_EN'             => $request->name_en,
            ];
         $Hotel = Hotel::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Hotel added successfully',
             'item'=>$Hotel,
         ]);     
    }
    public function addAirplane(Request $request)
    {
         $data = [
             'name_EN'             => $request->name_en,
            ];
         $Airplane = Airplane::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Airplane added successfully',
             'item'=>$Airplane,
         ]);     
    }

    public function addPackage(Request $request)
    {
         $data = [
             'name_EN'             => $request->name_en,
             'Hotel_id'             => $request->Hotel_id,
             'airplane_id'             => $request->airplane_id,
             'restaurant_id'             => $request->restaurant_id,
            ];
            // dd($request->name_en); 
         $Package = Package::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Package added successfully',
             'item'=>$Package,
         ]);     
    }



    public function add_Restaurant_Booking(Request $request)
    {
         $data = [
            
             'Restaurant_id'             => $request->restaurant_id,
             'user_id'             => $request->user_id,
            ];
         $BookingRestaurant = BookingRestaurant::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'BookingRestaurant added successfully',
             'item'=>$BookingRestaurant,
         ]);     
    }

    public function add_Hotel_Booking(Request $request)
    {
         $data = [
            
             'hotel_id'             => $request->hotel_id,
             'user_id'             => $request->user_id,
            ];
         $BookingHotel = BookingHotel::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Booking Hotel added successfully',
             'item'=>$BookingHotel,
         ]);     
    }

    public function add_Airplane_Booking(Request $request)
    {
         $data = [
            
             'Airplane_id'             => $request->airplane_id,
             'user_id'             => $request->user_id,
            ];
         $BookingAirplane = BookingAirplane::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Booking Airplane  added successfully',
             'item'=>$BookingAirplane,
         ]);     
    }


    public function add_Package_Booking(Request $request)
    {
         $data = [
             'Package_id'             => $request->Package_id,
             'user_id'             => $request->user_id,
            ];
            
            $Booking = BookingPackage::with('package')->where('id',1)->first();
            dd($Booking->package->airplane->name_EN);

            $BookingPackage = BookingPackage::create($data);
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
