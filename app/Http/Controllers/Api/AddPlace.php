<?php
namespace App\Http\Controllers;
use App\Models\Airplane\AirplaneBooking;
use App\Models\Package\PackageBooking;
use App\Models\Restaurant\RestaurantBooking;
use App\Models\Hotel\HotelBooking;
use App\Models\Airplane\Airplane;
use App\Models\Hotel\Hotel;
use App\Models\Package\Package;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class add extends Controller
{

    public function addRestaurant(Request $request)
    {
        $validator = Validator::make($request-> all(),[
            'name'          => ['required', 'string', 'max:50','min:3'],
            'rate'          => 'required',
            'location'      => 'required',
            'support_email' => 'required',
            'img_title_deed'=> 'required',
             // 'Payment'    => 'nullable',
             'price_calss_A' => 'nullable',
             'price_calss_B' => 'nullable',
        ]);
        if ($validator->fails())
        {
            return response()->json(['message'      => $validator->errors()],400);
        }
         $data = [
             'name'          => $request->name,
             'rate'          => $request->rate,
             'location'      => $request->location,
             'Payment'       => $request->Payment,
             'price_calss_A' => $request->price_calss_A,
             'price_calss_B' => $request->price_calss_B,
             'support_email' => $request->support_email,
             'img_title_deed'=> $request->img_title_deed,
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
             'name_en'             => $request->name_en,
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
             'name_en'             => $request->name_en,
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
             'name_en'             => $request->name_en,
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



    public function add_Restaurant_Booking(Request $request)
    {
         $data = [
            
             'restaurant_id'             => $request->restaurant_id,
             'user_id'             => $request->user_id,
            ];
         $BookingRestaurant = RestaurantBooking::create($data);
     
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
         $BookingHotel = HotelBooking::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Booking Hotel added successfully',
             'item'=>$BookingHotel,
         ]);     
    }

    public function add_Airplane_Booking(Request $request)
    {
         $data = [
            
             'airplane_id'             => $request->airplane_id,
             'user_id'             => $request->user_id,
            ];
         $BookingAirplane = AirplaneBooking::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Booking Airplane  added successfully',
             'item'=>$BookingAirplane,
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
