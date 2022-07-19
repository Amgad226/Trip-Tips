<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airplane\Airplane;
use App\Models\Airplane\AirplaneBooking;
use App\Models\Airplane\AirplaneClass;
use App\Models\Restaurant\RestaurantBooking;
use App\Models\Restaurant\Restaurant;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelBooking;
use App\Models\Hotel\HotelClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Package\Package;
use App\Models\Package\PackageAirplane;
use App\Models\Package\PackageBooking;
use App\Models\Package\PackageComment;
use App\Models\Package\PackageHotel;
use App\Models\Package\PackagePlace;
use App\Models\Package\PackageRestaurant;
use App\Models\Place\Place;
use App\Models\TouristSupervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function addPackage(Request $request)
    {
        $validator = Validator::make($request-> all(),[
            'name'               => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:50','min:3'],
            'description'        => 'required',
            'max_reservation'    => 'required|integer',
            'start_date'               =>'required',
            'number_of_day'            =>'required|integer',
            'tourist_supervisor_id'    =>'required',
            'category_id'    =>    ['required', 'exists:catigories_package,id'],

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

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
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
            $start_end = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date);
            $daysToAdd = $request->number_of_day;
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date)->addDays($daysToAdd);
            
            // echo $start_end;
            // echo "\n".$end_date;
            // return;
            // dd($request->category_id);
            $data = [
                'name'                 => $request->name,
                'price'                => $request->price,
                'max_reservation'      => $request->max_reservation,
                'description'          => $request->description,
                'discount_percentage'  => $request->discount_percentage,
                'added_by'             => Auth::user()->name,
                'img'                  => $image_path,
                'start_date'           =>$start_end->format('Y-m-d H:i:s'),
                'end_date'             =>$end_date->format('Y-m-d H:i:s'),
                'number_of_day'        =>$request->number_of_day,
                'tourist_supervisor_id'=>$request->tourist_supervisor_id,
                'category_id'          =>$request->category_id,
                'discount_percentage'   =>$request->discount_percentage
               ];

         $Package = Package::create($data);
         return response()->json([
             'status' => '1',
             'message' => 'Package added successfully',
             'package'=>$Package,
         ]);     
    }

    public function addFaciliticsToPackage(Request $request)
    {
        $validator = Validator::make($request-> all(),[
           
            'package_id'          =>  ['required', 'exists:packages,id'],
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

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }
        if(PackageRestaurant::where('package_id',$request->package_id)->first()|| PackageHotel::where('package_id',$request->package_id)   ->first()  ||PackagePlace::where('package_id',$request->package_id) ->first()    ||PackageAirplane::where('package_id',$request->package_id)->first())
        {
            return response()->json(['message'=>'allready add fasilitis to this package ','status'=>0],400);
        }


        $package_id=$request->package_id;
      
        $restaurants_price=0;
        if($request->restaurant_id!=null && $request->restaurant_booking_date!=null){
            $restaurants_id= $request->restaurant_id;
            $restaurant_booking_date= $request->restaurant_booking_date;
            // dd(count($restaurant_booking_date),count($restaurants_id));
            // if(1==2){
            if(count($restaurant_booking_date)!=count($restaurants_id))
                return response()->json(['message'=>'you should enter booking date to all restaurants','status'=>0,]);
                
                for ($i=0 ; $i<count($restaurants_id);$i++)
                {
                    // print_r($restaurants_id);
                    // dd($restaurant_booking_date[$i]);
                    $restaurant=Restaurant::where('id',$restaurants_id[$i])->first() ;
                    if ( !Restaurant::where('id',$restaurants_id[$i])->first() ) 
                    {
                        PackagePlace::where('package_id',$package_id)->delete();
                        PackageAirplane::where('package_id',$package_id)->delete();
                        PackageHotel::where('package_id',$package_id)->delete();
                        PackageRestaurant::where('package_id',$package_id)->delete();
                        return response()->json(['status'=>0 , 'message'=>'restaurant dose not exist, we cancel adding all fasilitis to this package ,try again .']);
                    }
                    // dd($restaurant->name);
                    PackageRestaurant::create([
                    'restaurant_id'=>$restaurants_id[$i],
                    'restaurant_name'=> $restaurant->name,
                    'package_id'=>$package_id,
                    'restaurant_booking_date'=>$restaurant_booking_date[$i],
                ]);
                    // dd();
                    $restaurant_id = $restaurants_id[$i];
                    $rest=Restaurant::where('id',$restaurant_id)->first();
                    $restaurants_price= $restaurants_price + $rest->price_booking;      
                }
                // return $restaurants_price;
       
        }

        $hotels_price=0;
        if($request->hotel_class_id!=null&& $request->hotel_booking_start_date!=null&& $request->hotel_booking_end_date!=null)
        {
            // dd();
            $hotels_classes_id= $request->hotel_class_id;
            $hotel_booking_start_date= $request->hotel_booking_start_date;
            $hotel_booking_end_date= $request->hotel_booking_end_date;

            if(count($hotel_booking_start_date)!=count($hotels_classes_id)&&count($hotel_booking_start_date)!=count($hotel_booking_end_date))
                return response()->json(['status'=>0,'message'=>'you should enter booking date to all restaurants']);

            for ($i=0 ; $i<count($hotels_classes_id);$i++)
            {
                $hotelClass=HotelClass::where('id',$hotels_classes_id[$i])->first();
                if (!HotelClass::where('id',$hotels_classes_id[$i])->first() ) 
                {

                    PackagePlace::where('package_id',$package_id)->delete();
                    PackageAirplane::where('package_id',$package_id)->delete();
                    PackageHotel::where('package_id',$package_id)->delete();
                    PackageRestaurant::where('package_id',$package_id)->delete();
                    return response()->json(['status'=>0 , 'message'=>'Hotel dose not exist, we cancel adding all fasilitis to this package ,try again .']);
                }
                $hotel_class=HotelClass::where('id',$hotels_classes_id[$i])->first();
                $price_hotel=$hotel_class->money;
                $hotel_id=$hotel_class->hotel->id;
                PackageHotel::create([
                'hotel_id'=>$hotel_id ,
                'hotel_name'=>$hotelClass->hotel->name ,
                'class_hotel_id'=>$hotels_classes_id[$i],
                'hotel_class_name'=>$hotelClass->class_name,
                'package_id'=>$package_id , 
                'hotel_booking_end_date'=>$hotel_booking_end_date[$i],
                'hotel_booking_start_date'=>$hotel_booking_start_date[$i]
             ]);

                $hotels_price= $hotels_price + $price_hotel;      
            }
            //    return   $hotels_price;
        }   
        // dd();  
     
        $airplanes_price=0;
        if($request->airplane_class_id!=null&& $request->airplane_booking_date!=null)
        {
            $airplanes_classes_id= $request->airplane_class_id;
            $airplanes_booking_date= $request->airplane_booking_date;
            $from= $request->from;
            $to= $request->to;
            
            if(count($airplanes_booking_date)!=count($airplanes_classes_id)&&count($from)!=count($to)&&count($from)!=count($restaurants_id))
                return response()->json(['status'=>0,'message'=>'you should enter booking date to all airplanes']);

                for ($i=0 ; $i<count($airplanes_classes_id);$i++)
                {
                    // dd('s');
                    
                    $airplaneClass=AirplaneClass::where('id',$airplanes_classes_id[$i])->first() ;
                    if (!AirplaneClass::where('id',$airplanes_classes_id[$i])->first() ) 
                    {

                        PackagePlace::where('package_id',$package_id)->delete();
                        PackageAirplane::where('package_id',$package_id)->delete();
                        PackageHotel::where('package_id',$package_id)->delete();
                        PackageRestaurant::where('package_id',$package_id)->delete();
                        return response()->json(['status'=>0 , 'message'=>'this airplane dose not exist, we cancel adding all fasilitis to this package ,try again .']);
                    }
                    $airplane_class=AirplaneClass::where('id',$airplanes_classes_id[$i])->first();
                    $price_airplane=$airplane_class->money;
                    $airplane_id=$airplane_class->airplane->id;
                    PackageAirplane::create(
                        [
                        'airplane_id'          =>$airplane_id ,
                        'airplane_name'          =>$airplaneClass->airplane->name,
                        'class_airplane_id'    =>$airplanes_classes_id[$i],
                        'airplane_class_name'    =>$airplaneClass->class_name,
                        'package_id'           =>$package_id , 
                        'airplane_booking_date'=>$airplanes_booking_date[$i],
                        'from'                  =>$from[$i],
                        'to'                    =>$to[$i],

                    ]);
                    $airplanes_price= $airplanes_price + $price_airplane;      
                }
        }
   
        if($request->place_id!=null && $request->place_booking!=null){
            // dd();
            $place_id= $request->place_id;
            $a=(count($place_id));

            $place_booking= $request->place_booking;
            // dd(count($place_booking),count($place_id));
            // if(1==2){
            if(count($place_booking)!=count($place_id))
            
                return response()->json(['message'=>'you should enter booking date to all palaces','status'=>0,]);

                for ($i=0 ; $i<$a;$i++)
                {
                    $place=Place::where('id',$place_id[$i])->first();
                    if (!$place ) 
                    {

                        PackagePlace::where('package_id',$package_id)->delete();
                        PackageAirplane::where('package_id',$package_id)->delete();
                        PackageHotel::where('package_id',$package_id)->delete();
                        PackageRestaurant::where('package_id',$package_id)->delete();
                        return response()->json(['status'=>0 , 'message'=>'this place dose not exist, we cancel adding all fasilitis to this package ,try again .']);
                    }
                    PackagePlace::create(['place_id'=>$place_id[$i] ,'place_name'=>$place->name,'package_id'=>$package_id,'place_booking'=>$place_booking[$i]]);
                    // echo $place_id[$i] . "\n" . $place_booking[$i]."\n".$package_id;
                    // dd($package_id);

          
                }
        }
       
        $Package = Package::where('id',$package_id)->first();
        $full_price=$restaurants_price + $hotels_price + $airplanes_price;
        // echo "full_price ".$full_price."\n";
        $Discount_price = ($Package->discount_percentage / 100) * $full_price;
        // echo "Discount_price  ".$Discount_price."\n";
        $price_after_discount = $full_price-$Discount_price;
        // echo "price_after_discount  ".$price_after_discount."\n";

        // return;
        $Package->update(['price'=>$price_after_discount]);
        return response()->json(['status'=>1,
        'message'=>'added successfully',
        'full_price'=>$full_price,
        'Discount_price'=>$Discount_price,
        'price_after_discount'=>$price_after_discount,
        
    
    ]);
               
    }
   
    public function get_Packages(){
        $Packages = Package::with('PackageAirplane','PackageRestaurant','PackageHotel','PackagePlace','category','tourisSupervisor')->get();

        $airplanes=[];
        $restaurants=[];
        $hotels=[];
        $places=[];

        foreach($Packages as $Package)
        {
            foreach ($Package->PackageAirplane as $PackageAirplane ){
                $airplanes[]=( Airplane::with('classes')->where('id', $PackageAirplane->airplane_id)->get());
                
            }
           
        
         $airplanes = array_unique($airplanes); 
   
       
            foreach ($Package->PackageRestaurant as $PackageRestaurant ){
                $restaurants[]=( Restaurant::with('images','category')->where('id', $PackageRestaurant->restaurant_id)->get());
            }

        
         $restaurants = array_unique($restaurants); 

      
            foreach ($Package->PackageHotel as $PackageHotel ){
                $hotels[]=( Hotel::with('images','classes','category')->where('id', $PackageHotel->hotel_id)->get());
            }
        
         $hotels = array_unique($hotels); 

          //  return $restaurants;

       
            foreach ($Package->PackagePlace as $PackagePlace ){
                $places[]=( Place::with('image','category')->where('id', $PackagePlace->place_id)->get());
            }
          $places = array_unique($places); 
        }
      
        return  response()->json([
        'status'=>1,
        'package'=>$Packages,
        'airplane in package'=>$airplanes,
        'restaurant in package'=>$restaurants,
        'hotels in package'=>$hotels,
        'places in package'=>$places,
        ]);
    }
      
    public function add_Package_Booking(Request $request)
    {
        $validator = Validator::make($request-> all(),[

            // 'users'    => ['required', 'exists:users,id,admin_id,1']

            'package_id'      =>  ['required', 'exists:packages,id'],//,admin_id,1
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

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }
        $package_id=$request->package_id;
        // $price=$request->price* $request->number_of_people;
        /*

        billing
        
        */

        
            //    return  $BookingPackage->package;
            $package=Package::with('PackageAirplane')->where('id',$package_id)->first();
            // return $package; 
            $start_date=$package->start_date;
            $end_date=$package->end_date;

            $max_reservation= $package->max_reservation;
            $number_of_reservation= $package->number_of_reservation;

            $number_of_reservation+=$request->number_of_people;
            if($number_of_reservation>$max_reservation)
            {
                return response()->json(['message'=>'booking of this package is over ','status'=>0],200);
            }
            //  $number_of_reservation->save();
            $data = [
                'package_id'      => $package_id,
                'user_id'         => Auth::id(),
                'number_of_people'=> $request->number_of_people,
                'price'           =>$package->price*$request->number_of_people,
                'start_date'        =>$start_date,
                'end_date'          =>$end_date,
                'unique'             =>Str::random(16)

               ];
           $BookingPackage = PackageBooking::create($data);
           Package::where('id',$package_id)->update(['number_of_reservation'=>$number_of_reservation]);
        //  return;
        $token = Str::random(4);
        $image = QrCode::format('png')
        ->generate('http://127.0.0.1:8000/api/booking-info/'.$BookingPackage->user_id.'/'.$token.'/'.$BookingPackage->id.'/'.$BookingPackage->unique.'?type=pack');
        
        
        Storage::disk('local')->makeDirectory('public/images/package/'.$BookingPackage->package->name.'/qr');
        
        $a='public/images/package/'.$BookingPackage->package->name.'/qr/'.Auth::user()->name.time().'.png';
        Storage::disk('local')->put($a, $image);  
        
        
        $Price_All=0;
        // dd($BookingPackage->unique);
    
             if($BookingPackage->package->PackageRestaurant){
                   foreach($BookingPackage->package->PackageRestaurant as $a)
                   {
                       // return $a;
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
                          $Price_All+=$price_booking;
                           RestaurantBooking::create($data);
                      
                   }
        }
        // return $BookingPackage->package->PackageHotel;
        if($BookingPackage->package->PackageHotel){

            foreach($BookingPackage->package->PackageHotel as $a)
            {
                // return $a;

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
                $hotel_class_id=$a->class_hotel_id;
                $number_of_people=$request->number_of_people;
                $people_in_class=$a->class->number_of_people;
                $price=$a->class->money;
                $start_date=$a->hotel_booking_start_date;
                $end_date=$a->hotel_booking_end_date;
                $room=ceil($number_of_people/$people_in_class);
                // echo 'room '.($room) ."\n";
         
                $data = [
                    'hotel_id'        => $hotel_id,
                    'hotel_class_id'  =>$hotel_class_id,
                    'user_id'         => Auth::id(),
                    'number_of_people'=>$number_of_people,
                    'number_of_room'  =>$room,
                    'price'           =>$price,
                    'start_date'      =>$start_date,
                    'end_date'        =>$end_date,
                    'note'            =>null,
                    'by_packge'       =>1,
                   ];
                   $Price_All+=$price;

                 $a=   HotelBooking::create($data);
             // echo $a;
            }
        }
        // dd();

        if($BookingPackage->package->PackageAirplane){
        
            foreach($BookingPackage->package->PackageAirplane as $a)
            {
                // return $a;

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
                    'airplane_class_id'=>$a->class_airplane_id,
                    'user_id'         => Auth::id(),
                    'from'            => $from,
                    'to'              => $to,
                    'number_of_people'=>$number_of_people,
                    'price'           => $price_booking,
                    'date'            =>$date,
                    'by_packge'       =>1,
                    'note'            =>null,
                   ];
                   $Price_All+=$price_booking;

                    AirplaneBooking::create($data);  
                    // echo '111daskjdashd';
            }
        }
        // echo $Price_All ."\n";
            $Booking = PackageBooking::where('package_id',$package_id)->first();

         return response()->json([
            'status'=>1,
            'message' => 'Booking Package  added successfully',
            'booking_info'=>$Booking,
         ]);     
    }

    
    public function ِAddTouristSupervisor(Request $req){   

       
        $validator = Validator::make($req-> all(),[
            'name'    =>    ['required',],
            'phone'   =>    ['required',],
            'location'=>    ['required',],
            ]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }

        $TouristSupervisor=  TouristSupervisor::create( ['name'=>$req->name ,'phone'=>$req->phone,'location'=>$req->location  ]);
        return response()->json( ['message'=>'done','status'=>1,'TouristSupervisor'=>$TouristSupervisor],200);
        
    }
    
    public function DeleteTouristSupervisor(Request $req){   

       
        $validator = Validator::make($req-> all(),[
            'id'    =>    ['required', 'exists:tourist_supervisors,id'],
            ]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }

        $TouristSupervisor=  TouristSupervisor::where('id',$req->id);
        $TouristSupervisor->delete();
        return response()->json( ['message'=>'done','status'=>1],200);
        
    }

    
    public function add_Package_Comment(Request $request) {


        $validator = Validator::make($request-> all(),[
           
            'package_id'     =>  ['required', 'exists:packages,id'],
            'comment'  => 'required',
        ]);

        if ($validator->fails())
        {
            // return response()->json(['message'      => $validator->errors()],400);
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }
        
        $data_of_comment =
                [
                    'user_id'             => Auth::id(),
                    'package_id'         => $request->package_id,
                    'comment'             => $request->comment,                
                ];
     $commnet= PackageComment::create($data_of_comment);

        return response()->json([
            'status' => 1,
            'message'=>'Your comment has been added',
            'id'=>$commnet->id
        ]); 
    }
    
    public function remove_Package_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>  ['required', 'exists:package_comments,id'],
        ]);

        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }
            return response()->json( ['message'=>$errors['message'],'status'=>0],400);

        }

         $comment=PackageComment::where('id',$request->comment_id)->first();
            if(Auth::user()->role_person_id>1||$comment->user_id==Auth::id())
            {
                $comment->delete();
                return response()->json([
                    'status' => 1,
                    'message'=>'Your comment has been deleted'
                ]);
            }
    
        return response()->json([
            'status' => 0,
            'message' => 'access denied' ]);
    
    }

    public function Show_Package_Comments(Request $request){

        $validator = Validator::make($request-> all(),[

            'package_id'      =>  ['required', 'exists:packages,id'],
        ]);

        if ($validator->fails())
        {
            // return response()->json(['message'      => $validator->errors()],400);
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }
            return response()->json( ['message'=>$errors['message'],'status'=>0],400);

        }

        $comments = PackageComment::with('user')->where('package_id',$request->package_id)->get();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comments   ]));
    } 

    public function Show_Package_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>['required', 'exists:package_comments,id'],
        ]);

        if ($validator->fails())
        {
            // return response()->json(['message'      => $validator->errors()],400);
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }
            return response()->json( ['message'=>$errors['message'],'status'=>0],400);

        }
        $comment = PackageComment::with('user')->where('id',$request->comment_id)->first();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comment   ]));
    } 
    
}
