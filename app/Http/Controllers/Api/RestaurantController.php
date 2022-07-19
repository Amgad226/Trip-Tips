<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AcceptFacilities;

use App\Models\Restaurant\RestaurantBooking;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantClass;
use App\Models\Restaurant\RestaurantComment;
use App\Models\Restaurant\RestaurantImage;
use App\Models\Restaurant\RestaurantRole;

use App\Models\User;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use  Image;

class RestaurantController extends Controller
{

    public function addRestaurant(Request $request){   

            $validator = Validator::make($request-> all(),[
            'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:20','min:3'],
            'rate'          => 'required',
            'location'      => 'required',
            'support_email' => 'required|email',
            'img_title_deed'=> 'required',
            'img'           => 'required',
            'price_booking' => 'required',
            'description'   => 'required',
            'catigory_id'    =>    ['required', 'exists:catigories_restaurant,id'],
            
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
            // dd();
            if(!$request->hasFile('img'))
            {     return response()->json(['message' => 'The img  field is required' ]);   
            }
            if($request->img[0]==null)
            {     return response()->json(['message' => 'The img222  field is required' ]);   
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
            $image_resize->save(public_path("/storage/images/restaurant/".$Restuarant_Name.'/title_deed/'.$Restuarant_Name.$extension ));
            //store without resize 
            // $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Restuarant_Name.$extension);  

            $image_title_deed_path = "/storage/images/restaurant/".$Restuarant_Name.'/title_deed/'. $Restuarant_Name.$extension;        
         
         
         $data = [
            'user_id'=>Auth::id(),
            'name'          => $request->name,
            'rate'          => $request->rate,
            'location'      => $request->location,
            'price_booking' => $request->price_booking, 
            'Payment'       => config('global.Payment_retaurant'),
            'support_email' => $request->support_email,
            'img_title_deed'=> $image_title_deed_path, 
            'description'   =>$request->description,
            'catigory_id'   =>$request->catigory_id,

           ];
           
         $restaurant = Restaurant::create($data);

         $restaurant_role=RestaurantRole::create(['user_id'=>Auth::id(),'restaurant_id'=>$restaurant->id,'role_facilities_id'=>1]);
 
         $Restaurant_name=$request->name;
         $facilities_name=$restaurant_role->facilitie->role_name;
        // 
         $restaurant_role->restaurant_name=$Restaurant_name;
         $restaurant_role->role_facilities_name=$facilities_name;
         $restaurant_role->save();

         DB::table('users')->where('id',Auth::id())->update(['have_facilities' =>1]);

        //  $data = [];

         $images_restaurant=$request->img;
         $i=1;
         // return($request->img);
         foreach($images_restaurant as $image_restaurant) 
         {   
                // dd(json_decode($image_restaurant));
                // dd($image_restaurant);
                $extension='.'.$image_restaurant->getclientoriginalextension();

                 if(!in_array($extension, config('global.allowed_extention')))
                 {
                    // File::deleteDirectory(public_path('storage/a'));
                    File::deleteDirectory(public_path('storage/images/restaurant/'.$request->name));
                    RestaurantImage::where('restaurant_id',$restaurant->id)->delete();
                    $restaurant->delete();

                     return response()->json(['message' => 'restaurant doesnot regeistered because you enter invalide image ectension' ]);   
                 }
                $destination_path ='public/images/restaurant/'.$Restuarant_Name; //غير مستعمل

                //store with resize
                $image=$image_restaurant ; 
                $image_resize = Image::make($image->getRealPath());      
                // dd($image_resize);        
                $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
                $image_resize->save(public_path("/storage/images/restaurant/".$Restuarant_Name ."/". $i."_".$Restuarant_Name.$extension ));

                //store without resize
                // $image_restaurant->storeAs($destination_path,  $i."_". $Restuarant_Name.$extension);  

                $image_path_to_database = "/storage/images/restaurant/".$Restuarant_Name ."/". $i."_".$Restuarant_Name.$extension;        
                $image_data=['img'=>$image_path_to_database,'restaurant_id'=>$restaurant->id];
                RestaurantImage::create($image_data);
                 $i++;
                
            
        }
      
       
         return response()->json([
             'status' => '1',
             'message' => 'restaurant added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of ' .config('global.max_day_for_repeating').' days',
            'id'=>$restaurant->id,
            //  'restaurant'=>$restauranttt,
         ]);     
    }

    public function AcceptResturant(Request $req){
        // dd( config('app.name')2);
        $restaurant_to_accept=Restaurant::where('id',$req->id)->first();
        
        if($restaurant_to_accept==null){
        return response()->json(['message'=>'restaurant not exists','status'=>0],400);
        }
        // dd($restaurant_to_accept->acceptable);
        if($restaurant_to_accept->acceptable==1){
        return response()->json(['message'=>'allready accepted','status'=>0],400);
        }
        $restaurant_to_accept->update(['acceptable'=>1]);
        $text='Congratulations your Restaurant '.$restaurant_to_accept->name.' has been accepted in trip tips manage your project by';
        $details=[
            'body'=>$text,
            'link_to_web'=>'1'
        ]; 
        // dd();
               //بعتنا عل ايميل الدعم رسالة نجاح تسجيل المطعم بل برنامج عنا 
        Mail::to($restaurant_to_accept->support_email)->send(new AcceptFacilities ($details));   
        return response()->json(['message'=>' email sent,and accept successfuly','status'=>1,'acceptable'=>$restaurant_to_accept->acceptable],200);
    }

    public function RefusResturant(Request $req){

        $restaurant_to_refuse= Restaurant::where('id',$req->id)->first();
        // dd($r);

        if($restaurant_to_refuse==null){
        return response()->json(['message'=>'restaurant not exists','status'=>0],400);
        }
        if($restaurant_to_refuse->acceptable==1){
        return response()->json(['message'=>'this restaurant is accepteble','status'=>0],400);
        }
        else{
            
            $text='Sorry your Restaurant '.$restaurant_to_refuse->name.'  has been Refus by Admins Because your restaurant does not follow the conditions of society TripTips ';
            $details=[
                'body'=>$text,
                'link_to_web'=>0
            ];
            //بعتنا عل ايميل تبع اليوزر هاد الرمز 
        Mail::to($restaurant_to_refuse->support_email)->send(new AcceptFacilities ($details));   
        $res_name=$restaurant_to_refuse->name;
        File::deleteDirectory(public_path('storage/images/restaurant/'.$res_name));
        RestaurantImage::where('restaurant_id',$restaurant_to_refuse->id)->delete();
        $restaurant_to_refuse->delete();
        return response()->json(['message'=>'email sent,and refuse and delete information successfuly','status'=>1],200);
        }
    }

    public function ShowAllResturants(){

        $restaurant_acceptable = Restaurant::with('images','category')->where('acceptable',1)->get();
 
         return response()->json(['message'=>' successfuly','restaurants'=>$restaurant_acceptable,'status'=>1],200);
   
    }
    
    public function Show_Not_Active_Resturants(){

        $restaurant_acceptable = Restaurant::with('images','category')->where('acceptable',0)->get();
 
         return response()->json(['message'=>' successfuly','restaurants'=>$restaurant_acceptable,'status'=>1],200);
   
    }

    public function add_Restaurant_Booking(Request $request){
        //  Random() ;

        //  return rand(5, 15);
        $validator = Validator::make($request-> all(),[
            'number_of_people'=> 'required',
            'restaurant_id'   => 'required',
            // 'price'           => 'required',
            'booking_date'    => 'required|date',
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
            // dd()
            $data = [
                'restaurant_id'      => $request->restaurant_id,
                'user_id'            => Auth::id(),
                'number_of_people'   =>$request->number_of_people,
                'price'              =>$request->price,
                'booking_date'       =>$request->booking_date,
                'note'               =>$request->note,
                'by_packge'          =>0,
                'unique'             =>Str::random(16)
            
            
        ];
        $BookingRestaurant = RestaurantBooking::create($data);
        
        $token = Str::random(4);

        $image = QrCode::color(0, 36, 63)->format('png')->merge(public_path('default_photo/logo.png'), .3, true)
        ->size(500)
        ->generate('http://127.0.0.1:8000/api/booking-info/'.$BookingRestaurant->user_id.'/'.$token.'/'.$BookingRestaurant->id.'/'.$BookingRestaurant->unique.'?type=res');

        
        Storage::disk('local')->makeDirectory('public/images/restaurant/'.$BookingRestaurant->restuarant->name.'/qr');

        $a='public/images/restaurant/'.$BookingRestaurant->restuarant->name.'/qr/'.Auth::user()->name.time().'.png';
        Storage::disk('local')->put($a, $image);  
        
        
        return response()->json([
            'status' => '1',
            'message' => 'BookingRestaurant added successfully ,go to your profile to get image Qr code ',
            'info'=>$BookingRestaurant,
        ]);     
    }

    public function add_Restaurant_Comment(Request $request) {


        $validator = Validator::make($request-> all(),[
           
            'restaurant_id'     =>  ['required', 'exists:restaurants,id'],
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
                    'restaurant_id'         => $request->restaurant_id,
                    'comment'             => $request->comment,                
                ];
      RestaurantComment::create($data_of_comment);

        return response()->json([
            'status' => 1,
            'message'=>'Your comment has been added'
        ]); 
    }
    
    public function remove_Restaurant_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>  ['required', 'exists:restaurant_comments,id'],
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

         $comment=RestaurantComment::where('id',$request->comment_id)->first();
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

    public function Show_Restaurant_Comments(Request $request){

        $validator = Validator::make($request-> all(),[

            'restaurant_id'      =>  ['required', 'exists:restaurants,id'],
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

        $comments = RestaurantComment::with('user')->where('restaurant_id',$request->restaurant_id)->get();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comments   ]));
    } 

    public function Show_Restaurant_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>['required', 'exists:restaurant_comments,id'],
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
        $comment = RestaurantComment::with('user')->where('id',$request->comment_id)->first();
            return( response()->json([ 
                'status'=>1,
                'message'=> $comment   ]));
    } 
    
    
}
