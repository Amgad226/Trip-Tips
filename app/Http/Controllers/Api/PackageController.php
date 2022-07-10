<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AcceptFacilities;
use App\Models\Airplane\Airplane;
use App\Models\Airplane\AirplaneBooking;
use App\Models\Airplane\AirplaneClass;
use App\Models\Airplane\AirplaneRole;
use App\Models\Restaurant\RestaurantBooking;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantImage;
use App\Models\Restaurant\RestaurantRole;

use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelImages;
use App\Models\Hotel\HotelBooking;
use App\Models\Hotel\HotelClass;
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
        $validator = Validator::make($request-> all(),[
            'name'               => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:50','min:3'],
            'description'        => 'required',
            'max_reservation'    => 'required|integer',
            'discount_percentage'=> 'required|integer',
            'img'                => 'required',
            'restaurant_id'      => 'required|integer',//|unique:restaurants',
            'hotel_class_id'     => 'required|integer',//|unique:hotel_classes',
            'airplane_class_id'  => 'required|integer',//|unique:airplane_classes',
        ]);
        if ($validator->fails())
        {
            // return response()->json(['message'      => $validator->errors()],400);
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( $errors,400);
        }
       
    //        price
            $restaurant_id = $request->restaurant_id;
            $rest=Restaurant::where('id',$restaurant_id)->first();
            $price_restaurant=$rest->price_booking;

            $hotel_class_id=$request->hotel_class_id;
            $hotel_class=HotelClass::where('id',$hotel_class_id)->first();
            $price_hotel=$hotel_class->money;
            $hotel_id=$hotel_class->hotel->id;

            $airplane_class_id=$request->airplane_class_id;
            $airplane_class=AirplaneClass::where('id',$airplane_class_id)->first();
            $prica_airplane=$airplane_class->money;
            $airplane_id=$airplane_class->airplane->id;

            $price=($price_restaurant+$price_hotel+$prica_airplane)/$request->discount_percentage;



                
        if($request->hasFile('img'))
        { 
        $extension='.'.$request->img->getclientoriginalextension();
            
        if(!in_array($extension, config('global.allowed_extention')))
        {
            return response()->json(['message' => 'invalide image ectension' ]);   
        }
            $uniqid='('.uniqid().')';       
            $destination_path = 'public/images/package';     
            $request->file('img')->storeAs($destination_path,$uniqid.$request->img->getClientOriginalName());  
            $image_path = "/storage/images/package/" . $uniqid.$request->img->getClientOriginalName();         
         }
         else
         {
            $image_path='/default_photo/user_default.png' ;
         }
            $data = [
                'name'                => $request->name,
                'price'               => $request->price,
                'max_reservation'     => $request->max_reservation,
                'description'         => $request->description,
                'discount_percentage' => $request->discount_percentage,
                
                'added_by'            => Auth::id(),
                'img'                 => $image_path,
                'price'               => $price,
                'restaurant_id'       => $request->restaurant_id,
                'hotel_id'            => $hotel_id,
                'airplane_id'         => $airplane_id,
   
               ];
         $Package = Package::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Package added successfully',
             'item'=>$Package,
         ]);     
    }

   


    public function get_Packages(){
        $Package = Package::with('airplane','restaurant','hotel')->first();
        dd($Package->hotel->images);
        return $Package;

    }
    public function add_Package_Booking(Request $request)
    {
         $data = [
             'package_id'             => $request->Package_id,
             'user_id'             => $request->user_id,
            ];
        //  $Package = Package::create(number_of_reservation);
            
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
