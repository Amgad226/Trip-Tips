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

class AirplaneController extends Controller
{
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
            $image_resize->save(public_path("/storage/images/airplane/".$request->name.'/title_deed/'.$Airplane_Name.$extension ));
            //store without resize
            // $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Airplane_Name.$extension); 

            $image_title_deed_path = "/storage/images/airplane/".$request->name.'/title_deed/'.$Airplane_Name.$extension;

         
         $data = [
            'user_id'       =>Auth::id(),
            'name'          => $request->name,
            'location'      => $request->location,
            'Payment'       => config('global.Payment_airplane'),
            'support_email' => $request->support_email,
            'img_title_deed'=> $image_title_deed_path, 
           ];
         $airplane = Airplane::create($data);
         DB::table('users')->where('id',Auth::id())->update(['have_facilities' =>1]);
         AirplaneRole::create(['user_id'=>Auth::id(),'airplane_id'=>$airplane->id,'role_facilities_id'=>1]);
         
     
        
        //  $airplanett=airplane::where('id',$airplane->id)->first();
         //  dd($airplanett);
       
         return response()->json([
             'status' => '1',
             'message' => 'airplane added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of '.config('global.max_day_for_repeating').' days',
            //  'airplane'=>$airplanett,
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


    
}
