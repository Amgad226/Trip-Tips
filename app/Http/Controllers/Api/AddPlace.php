<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airplane\AirplaneBooking;
use App\Models\Package\PackageBooking;
use App\Models\Restaurant\RestaurantBooking;
use App\Models\Hotel\HotelBooking;
use App\Models\Airplane\Airplane;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelImages;
use App\Models\Package\Package;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class AddPlace extends Controller
{

    public function addRestaurant(Request $request)
    {       
            $validator = Validator::make($request-> all(),[
            'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:20','min:3'],
            // 'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:50','min:3','unique:restaurants'],
            'rate'          => 'required',
            'location'      => 'required',
            'support_email' => 'required|email',
            'Payment'       => 'nullable',
            'img_title_deed'=> 'required',
            'img'           => 'required',]);

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
            $extension='.'.$request->img_title_deed->getclientoriginalextension();

            if(!in_array($extension, config('global.allowed_extention')))
            {
                return response()->json(['message' => 'invalide image ectension' ]);   
            }
            Storage::disk('local')->makeDirectory('public/images/restaurant/'.$request->name);
            Storage::disk('local')->makeDirectory('public/images/restaurant/'.$request->name."/title_deed");
            $uniqid='('.uniqid().')';   
            $Restuarant_Name= $request->name;  
            $destination_path = 'public/images/restaurant/'.$request->name."/title_deed";    
            $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Restuarant_Name.$extension);  
            $image_title_deed_path = "/storage/images/restaurant/".$request->name.'/title_deed/'. $uniqid.$Restuarant_Name.$extension;        
         
         
         $data = [
            'name'          => $request->name,
            'rate'          => $request->rate,
            'location'      => $request->location,
            'Payment'       => $request->Payment,
            'support_email' => $request->support_email,
            'img_title_deed'=> $image_title_deed_path, 
           ];
         $restaurant = Restaurant::create($data);
         
         $images_restaurant=$request->img;
     
         if($request->hasFile('img')){   
            $i=1;
            foreach($images_restaurant as $image_restaurant) 
            {   
                $extension='.'.$image_restaurant->getclientoriginalextension();

                 if(!in_array($extension, config('global.allowed_extention')))
                 {
                    // File::deleteDirectory(public_path('storage/a'));
                    File::deleteDirectory(public_path('storage/images/restaurant/'.$request->name));
                    RestaurantImage::where('restaurant_id',$restaurant->id)->truncate();
                    $restaurant->delete();

                     return response()->json(['message' => 'restaurant doesnot regeistered because you enter invalide image ectension' ]);   
                 }
                $destination_path ='public/images/restaurant/'.$Restuarant_Name; 
                $image_restaurant->storeAs($destination_path,  $i."_". $Restuarant_Name.$extension);  
                $image_path_to_database = "/storage/images/restaurant/".$Restuarant_Name ."/". $i."_".$Restuarant_Name.$extension;        
                $image_data=['img'=>$image_path_to_database,'restaurant_id'=>$restaurant->id];
                RestaurantImage::create($image_data);
                 $i++;
                
            }
         }
         $restauranttt=Restaurant::with('images')->where('id',$restaurant->id)->first();
         //  dd($restauranttt);
       
         return response()->json([
             'status' => '1',
             'message' => 'restaurant added successfully',
             'restaurant'=>$restauranttt,
         ]);     
    }
//yass
//amgad 
    public function addHotel(Request $request)
    {
        // dd($request->img);
        $validator = Validator::make($request-> all(),[
            'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:20','min:3'],
            // 'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:50','min:3','unique:hotels'],
            'rate'          => 'required',
            'location'      => 'required',
            'support_email' => 'required|email',
            'Payment'       => 'nullable',
            'img_title_deed'=> 'required',
            'img'           => 'required',]);

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
            $extension='.'.$request->img_title_deed->getclientoriginalextension();

            if(!in_array($extension, config('global.allowed_extention')))
            {
                return response()->json(['message' => 'invalide image ectension' ]);   
            }
            Storage::disk('local')->makeDirectory('public/images/hotel/'.$request->name);
            Storage::disk('local')->makeDirectory('public/images/hotel/'.$request->name."/title_deed");
            $uniqid='('.uniqid().')';   
            $Restuarant_Name= $request->name;  
            $destination_path = 'public/images/hotel/'.$request->name."/title_deed";    
            $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Restuarant_Name.$extension);  
            $image_title_deed_path = "/storage/images/hotel/".$request->name.'/title_deed/'. $uniqid.$Restuarant_Name.$extension;        
         
         
         $data = [
            'name'          => $request->name,
            'rate'          => $request->rate,
            'location'      => $request->location,
            'Payment'       => $request->Payment,
            'support_email' => $request->support_email,
            'img_title_deed'=> $image_title_deed_path, 
           ];
         $hotel = Hotel::create($data);
         $images_hotel=$request->img;
        //  dd($images_hotel)
         
         if($request->hasFile('img')){   
             $i=1;
             foreach($images_hotel as $image_hotel) 
             {   
                //  dd();
                 $extension='.'.$image_hotel->getclientoriginalextension();
                //  dd();
                 if(!in_array($extension, config('global.allowed_extention')))
                 {
                     // File::deleteDirectory(public_path('storage/a'));
                     File::deleteDirectory(public_path('storage/images/hotel/'.$request->name));
                     HotelImages::where('hotel_id',$hotel->id)->truncate();
                     $hotel->delete();

                     return response()->json(['message' => 'hotel doesnot regeistered because you enter invalide image ectension' ]);   
                 }
                $destination_path ='public/images/hotel/'.$Restuarant_Name; 
                $image_hotel->storeAs($destination_path,  $i."_". $Restuarant_Name.$extension);  
                $image_path_to_database = "/storage/images/hotel/".$Restuarant_Name ."/". $i."_".$Restuarant_Name.$extension;   

                $image_data=['img'=>$image_path_to_database,'hotel_id'=>$hotel->id];
                HotelImages::create($image_data);
                // dd($a);
                 $i++;
                
            }
         }
         $hotellll=Hotel::with('s')->where('id',$hotel->id)->first();
         //  dd($hoteltt);
       
         return response()->json([
             'status' => '1',
             'message' => 'hotel added successfully',
             'hotel'=>$hotellll,
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
