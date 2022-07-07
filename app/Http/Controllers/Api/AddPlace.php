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
use Illuminate\Support\Facades\File;
use  Image;

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
            $Restuarant_Name= $request->name;  
            Storage::disk('local')->makeDirectory('public/images/restaurant/'.$Restuarant_Name);
            Storage::disk('local')->makeDirectory('public/images/restaurant/'.$Restuarant_Name."/title_deed");
            $uniqid='('.uniqid().')';   
            $destination_path = 'public/images/restaurant/'.$Restuarant_Name."/title_deed";   
            //store with resize
            $image=$request->file('img_title_deed') ; 
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
            $image_resize->save(public_path("/storage/images/restaurant/".$Restuarant_Name.'/title_deed/'.'resize '.$Restuarant_Name.$extension ));
            //store without resize 
            $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Restuarant_Name.$extension);  
            $image_title_deed_path = "/storage/images/restaurant/".$Restuarant_Name.'/title_deed/'. $Restuarant_Name.$extension;        
         
         
         $data = [
            'name'          => $request->name,
            'rate'          => $request->rate,
            'location'      => $request->location,
            'Payment'       => config('global.Payment_retaurant'),
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
                $image=$image_restaurant ; 
                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
                $image_resize->save(public_path("/storage/images/restaurant/".$Restuarant_Name ."/". $i.'resize'."_".$Restuarant_Name.$extension ));

                //store without resize
                $image_restaurant->storeAs($destination_path,  $i."_". $Restuarant_Name.$extension);  
                $image_path_to_database = "/storage/images/restaurant/".$Restuarant_Name ."/". $i."_".$Restuarant_Name.$extension;        
                $image_data=['img'=>$image_path_to_database,'restaurant_id'=>$restaurant->id];
                RestaurantImage::create($image_data);
                 $i++;
                
            }
         }
        //  $restauranttt=Restaurant::with('images')->where('id',$restaurant->id)->first();
         //  dd($restauranttt);
       
         return response()->json([
             'status' => '1',
             'message' => 'restaurant added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of ' .config('global.max_day_for_repeating').' days',

            //  'restaurant'=>$restauranttt,
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
            $Hotel_Name= $request->name;  
            Storage::disk('local')->makeDirectory('public/images/hotel/'.$Hotel_Name);
            Storage::disk('local')->makeDirectory('public/images/hotel/'.$Hotel_Name."/title_deed");
            $uniqid='('.uniqid().')';   
            $destination_path = 'public/images/hotel/'.$Hotel_Name."/title_deed"; 
            //store with resize
            $image=$request->file('img_title_deed') ; 
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
            $image_resize->save(public_path("/storage/images/hotel/".$Hotel_Name.'/title_deed/'.'resize '.$Hotel_Name.$extension ));
            //store without resize
            $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Hotel_Name.$extension); 
   
            $image_title_deed_path = "/storage/images/hotel/".$Hotel_Name.'/title_deed/'. $uniqid.$Hotel_Name.$extension;        
         
         
         $data = [
            'name'          => $request->name,
            'rate'          => $request->rate,
            'location'      => $request->location,
            'Payment'       => config('global.Payment_hotel'),
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
                $destination_path ='public/images/hotel/'.$Hotel_Name; 
                //store with resize
                $image=$image_hotel ; 
                $image_resize = Image::make($image->getRealPath());              
                $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
                $image_resize->save(public_path("/storage/images/hotel/".$Hotel_Name ."/". $i.'resize'."_".$Hotel_Name.$extension ));

                //store without resize
                $image_hotel->storeAs($destination_path,  $i."_". $Hotel_Name.$extension);
                
                
                $image_path_to_database = "/storage/images/hotel/".$Hotel_Name ."/". $i."_".$Hotel_Name.$extension;   

                $image_data=['img'=>$image_path_to_database,'hotel_id'=>$hotel->id];
                HotelImages::create($image_data);
                // dd($a);
                 $i++;
                
            }
         }
        //  $hotellll=Hotel::with('s')->where('id',$hotel->id)->first();
         //  dd($hoteltt);
       
         return response()->json([
             'status' => '1',
             'message' => 'hotel added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of ' .config('global.max_day_for_repeating').' days',

            //  'message' => 'hotel added successfully',
            //  'hotel'=>$hotellll,
         ]);    
    }
    public function addAirplane(Request $request)
    {
        $validator = Validator::make($request-> all(),[
            'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:20','min:3'],
            'location'      => 'required',
            'support_email' => 'required|email',
            'img_title_deed'=> 'required',
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
            $extension='.'.$request->img_title_deed->getclientoriginalextension();
            
            
            if(!in_array($extension, config('global.allowed_extention')))
            {
                return response()->json(['message' => 'invalide image ectension' ]);   
            }
            $Airplane_Name= $request->name;  
            Storage::disk('local')->makeDirectory('public/images/airplane/'.$Airplane_Name."/title_deed");
            $uniqid='('.uniqid().')';   
            $destination_path = 'public/images/airplane/'.$Airplane_Name."/title_deed";  
            //store with resize
            $image=$request->file('img_title_deed') ; 
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
            $image_resize->save(public_path("/storage/images/airplane/".$request->name.'/title_deed/'.'resize '.$Airplane_Name.$extension ));
            //store without resize
            $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Airplane_Name.$extension); 

            $image_title_deed_path = "/storage/images/airplane/".$request->name.'/title_deed/'.$Airplane_Name.$extension;

         
         $data = [
            'name'          => $request->name,
            'location'      => $request->location,
            'Payment'       => config('global.Payment_airplane'),
            'support_email' => $request->support_email,
            'img_title_deed'=> $image_title_deed_path, 
           ];
         $airplane = airplane::create($data);
         
     
        
        //  $airplanett=airplane::where('id',$airplane->id)->first();
         //  dd($restauranttt);
       
         return response()->json([
             'status' => '1',
             'message' => 'airplane added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of '.config('global.max_day_for_repeating').' days',
            //  'airplane'=>$airplanett,
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
