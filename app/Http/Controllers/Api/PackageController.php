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
use App\Models\Package\PackageAirplane;
use App\Models\Package\PackageBooking;
use App\Models\Package\PackageHotel;
use App\Models\Package\PackageRestaurant;
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
            // 'img'                => 'required',
    
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
               ];
         $Package = Package::create($data);
     
         return response()->json([
             'status' => '1',
             'message' => 'Package added successfully',
            //  'item'=>$Package,
         ]);     
    }

    public function addFaciliticsToPackage(Request $request)
    {
        $validator = Validator::make($request-> all(),[
           
            'package_id'         => 'required',
            // 'restaurant_id'      => 'required',
            // 'hotel_class_id'     => 'required',
            // 'airplane_class_id'  => 'required',
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
        $package_id=$request->package_id;

        $restaurants_price=0;
        if($request->restaurant_id!=null && $request->restaurant_booking_date!=null){
            $restaurants_id= $request->restaurant_id;
            $restaurant_booking_date= $request->restaurant_booking_date;
            // dd(count($restaurant_booking_date),count($restaurants_id));
            if(count($restaurant_booking_date)!=count($restaurants_id))
                return response()->json(['message'=>'you should enter booking date to all restaurants']);

                for ($i=0 ; $i<count($restaurants_id);$i++)
                {
                    // dd($restaurant_booking_date[$i]);
                    PackageRestaurant::create(['restaurant_id'=>$restaurants_id[$i] ,'package_id'=>$package_id,'restaurant_booking_date'=>$restaurant_booking_date[$i]]);
                    // dd();
                    $restaurant_id = $restaurants_id[$i];
                    $rest=Restaurant::where('id',$restaurant_id)->first();
                    $restaurants_price= $restaurants_price + $rest->price_booking;      
                }
        }
        $hotels_price=0;
        if($request->hotel_class_id!=null&& $request->hotel_booking_start_date!=null&& $request->hotel_booking_end_date!=null)
        {
            // dd();
            $hotels_classes_id= $request->hotel_class_id;
            $hotel_booking_start_date= $request->hotel_booking_start_date;
            $hotel_booking_end_date= $request->hotel_booking_end_date;

            if(count($hotel_booking_start_date)!=count($restaurants_id)&&count($hotel_booking_start_date)!=count($hotel_booking_end_date))
                return response()->json(['message'=>'you should enter booking date to all restaurants']);

            for ($i=0 ; $i<count($hotels_classes_id);$i++)
            {
                $hotel_class=HotelClass::where('id',$hotels_classes_id[$i])->first();
                $price_hotel=$hotel_class->money;
                $hotel_id=$hotel_class->hotel->id;
                PackageHotel::create([
                'hotel_id'=>$hotel_id ,
                'class_hotel_id'=>$hotels_classes_id[$i],
                'package_id'=>$package_id , 
                'hotel_booking_end_date'=>$hotel_booking_end_date[$i],
                'hotel_booking_start_date'=>$hotel_booking_start_date[$i]
            ]);

                $hotels_price= $hotels_price + $price_hotel;      
            }
          
        }
       
        $airplanes_price=0;
        if($request->airplane_class_id!=null&& $request->airplane_booking_date!=null)
        {
            $airplanes_classes_id= $request->airplane_class_id;
            $airplanes_booking_date= $request->airplane_booking_date;
            $from= $request->from;
            $to= $request->to;
            
            if(count($airplanes_booking_date)!=count($airplanes_classes_id)&&count($from)!=count($to)&&count($from)!=count($restaurants_id))
                return response()->json(['message'=>'you should enter booking date to all airplanes']);

                for ($i=0 ; $i<count($airplanes_classes_id);$i++)
                {
                    // dd('s');
                    $airplane_class=AirplaneClass::where('id',$airplanes_classes_id[$i])->first();
                    $price_airplane=$airplane_class->money;
                    $airplane_id=$airplane_class->airplane->id;
                    PackageAirplane::create(
                        [
                        'airplane_id'          =>$airplane_id ,
                        'class_airplane_id'    =>$airplanes_classes_id[$i],
                        'package_id'           =>$package_id , 
                        'airplane_booking_date'=>$airplanes_booking_date[$i],
                        'from'                  =>$from[$i],
                        'to'                    =>$to[$i],

                    ]);
                    $airplanes_price= $airplanes_price + $price_airplane;      
                }
        }
       
        $Package = Package::where('id',$package_id)->first();
        $price=($restaurants_price+$hotels_price+$airplanes_price)/$Package->discount_percentage;
        $Package->update(['price'=>$price]);
        return response()->json(['message'=>'added successfully']);
               
    }
   
    public function get_Packages(){
        $Packages = Package::with('PackageAirplane','PackageRestaurant','PackageHotel')->get();
        // return($Packages);
        $airplanes=[];
        foreach($Packages as $Package)
        {
            foreach ($Package->PackageAirplane as $PackageAirplane ){
                $airplanes[]=( Airplane::where('id', $PackageAirplane->airplane_id)->get());
                
            }
           
        }
        $airplanes = array_unique($airplanes); 
   
        $restaurants=array();
        foreach($Packages as $Package)
        {
            foreach ($Package->PackageRestaurant as $PackageRestaurant ){
                $restaurants[]=( Restaurant::with('images')->where('id', $PackageRestaurant->restaurant_id)->get());
            }
        }
        $restaurants = array_unique($restaurants); 

        $hotels=array();
        foreach($Packages  as $Package)
        {
            foreach ($Package->PackageHotel as $PackageHotel ){
                $hotels[]=( Hotel::with('images')->where('id', $PackageHotel->hotel_id)->get());
            }
        }
        $hotels = array_unique($hotels); 
     
        return  response()->json([
        'package'=>$Packages,
        'airplane in package'=>$airplanes,
        'restaurant in package'=>$restaurants,
        'hotels in package'=>$hotels,
        ]);
    }
      
    public function add_Package_Booking(Request $request)
    {
        $validator = Validator::make($request-> all(),[
           
            'package_id'      => 'required',
            'number_of_people'=> 'required',
            // 'price'           => 'required',
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
        $package_id=$request->package_id;
        // $price=$request->price* $request->number_of_people;
        /*

        billing
        
        */

         $data = [
             'package_id'      => $package_id,
             'user_id'         => Auth::id(),
             'number_of_people'=> $request->number_of_people,
            ];
            
        $BookingPackage = PackageBooking::create($data);
        
     
            foreach($BookingPackage->package->PackageRestaurant as $a)
            {
                
                // echo $a->restaurant_id."\n" ;
                // echo "\n" ;
                // echo "restaurant_id ".$a->restaurant_id."\n" ;
                // echo "user_id ".Auth::id()."\n";
                // echo "number_of_people ".$request->number_of_people."\n" ;
                // echo "price_booking ".$a->restaurant->price_booking."\n" ;
                // echo "booking_date ".$a->restaurant_booking_date."\n" ;
                // echo "user_id ".Auth::id()."\n";
                $resturant_id=$a->restaurant_id;
                $number_of_people=$request->number_of_people;
                $price_booking=$a->restaurant->price_booking;
                $booking_date=$a->restaurant_booking_date;

                $data = [
                    'restaurant_id'      => $resturant_id,
                    'user_id'            => Auth::id(),
                    'number_of_people'   =>$number_of_people,
                    'price'              =>$price_booking,
                    'booking_date'       =>$booking_date,
                    'note'               =>null,
                    'by_packge'          =>1,
                   ]; 
                    RestaurantBooking::create($data);

            }
            foreach($BookingPackage->package->PackageHotel as $a)
            {

                // echo $a->hotel_id."\n" ;
                // echo "\n" ;
                // echo "hotel_id ".$a->hotel_id."\n" ;
                // echo "user_id ".Auth::id()."\n";
                // echo "number_of_people ".$request->number_of_people."\n" ;
                // echo "price_booking ".$a->class->money."\n" ;
                // echo "number_of_people in class ".$a->class->number_of_people."\n" ;
                // echo "stert date ".$a->hotel_booking_start_date."\n" ;
                // echo "end date ".$a->hotel_booking_end_date."\n" ;
                // echo "user_id ".Auth::id()."\n";

                $hotel_id=$a->hotel_id;
                $number_of_people=$request->number_of_people;
                $people_in_class=$a->class->number_of_people;
                $price=$a->class->money;
                $start_date=$a->hotel_booking_start_date;
                $end_date=$a->hotel_booking_end_date;
                $room=ceil($number_of_people/$people_in_class);
                // echo 'room '.($room) ."\n";
         
                $data = [
                    'hotel_id'        => $hotel_id,
                    'user_id'         => Auth::id(),
                    'number_of_people'=>$number_of_people,
                    'number_of_room'  =>$room,
                    'price'           =>$price,
                    'start_date'      =>$start_date,
                    'end_date'        =>$end_date,
                    'note'            =>null,
                    'by_packge'       =>1,
                   ];
                    HotelBooking::create($data);

            }

            foreach($BookingPackage->package->PackageAirplane as $a)
            {
                // echo $a->airplane_id."\n" ;
                // echo "\n" ;
                // echo "airplane_id ".$a->airplane_id."\n" ;
                // echo "user_id ".Auth::id()."\n";
                // echo "price  ".$a->class->money."\n" ;
                // echo "number_of_people ".$request->number_of_people."\n" ;
                // echo "airplane_booking_date	 ".$a->airplane_booking_date."\n" ;
                // echo "from ".$a->to."\n" ;
                // echo "user_id ".Auth::id()."\n";
            
                $airplane_id     =$a->airplane_id;
                $from            =$a->from;
                $to              =$a->to;
                $date            =$a->airplane_booking_date;
                $price_booking   =$a->class->money;
                $number_of_people=$request->number_of_people;
            
                $data = [
                    'airplane_id'     => $airplane_id,
                    'user_id'         => Auth::id(),
                    'from'            => $from,
                    'to'              => $to,
                    'number_of_people'=>$number_of_people,
                    'price'           => $price_booking,
                    'date'            =>$date,
                    'by_packge'       =>1,
                    'note'            =>null,
                   ];
                    AirplaneBooking::create($data);  
            }

            $Booking = PackageBooking::where('id',$package_id)->first();

         return response()->json([
             'status' => '1',
             'message' => 'Booking Package  added successfully',
             'booking_info'=>$BookingPackage,
            //  'booking_info'=>$Booking, //without info 
         ]);     
    }
}
