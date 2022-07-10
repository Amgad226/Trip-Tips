<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AcceptFacilities;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelImages;
use App\Models\Hotel\HotelBooking;
use App\Models\Hotel\HotelClass;
use App\Models\Hotel\HotelRole;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use  Image;

class HotelController extends Controller
{

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
            $image_resize->save(public_path("/storage/images/hotel/".$Hotel_Name.'/title_deed/'.$Hotel_Name.$extension ));
            //store without resize
            // $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$Hotel_Name.$extension); 
   
            $image_title_deed_path = "/storage/images/hotel/".$Hotel_Name.'/title_deed/'.$Hotel_Name.$extension;        
         
         
         $data = [
            'user_id'       =>Auth::id(),
            'name'          => $request->name,
            'rate'          => $request->rate,
            'location'      => $request->location,
            'Payment'       => config('global.Payment_hotel'),
            'support_email' => $request->support_email,
            'img_title_deed'=> $image_title_deed_path, 
           ];
         $hotel = Hotel::create($data);
         DB::table('users')->where('id',Auth::id())->update(['have_facilities' =>1]);
         HotelRole::create(['user_id'=>Auth::id(),'hotel_id'=>$hotel->id,'role_facilities_id'=>1]);
         
         $images_hotel=$request->img;
        //  dd($images_hotel)
         
         if($request->hasFile('img'))
           {   
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
                  $image_resize->save(public_path("/storage/images/hotel/".$Hotel_Name ."/". $i."_".$Hotel_Name.$extension ));
  
                  //store without resize
                  // $image_hotel->storeAs($destination_path,  $i."_". $Hotel_Name.$extension);
                  
                  
                  $image_path_to_database = "/storage/images/hotel/".$Hotel_Name ."/". $i."_".$Hotel_Name.$extension;   
  
                  $image_data=['img'=>$image_path_to_database,'hotel_id'=>$hotel->id];
                  HotelImages::create($image_data);
                  // dd($a);
                   $i++;
                
                }
            }
            //اضافة الاسعر الخاصة بالاوتيل 
         $classes=$request->classes;
         $names=$request->names;
         for ($i=0;$i<count($classes);$i++)
         {
         HotelClass::create(['hotel_id'=>$hotel->id,'money'=>$classes[$i],'class_name'=>$names[$i]]);
         }
        //  $hotellll=Hotel::with('images')->where('id',$hotel->id)->first();
         //  dd($hoteltt);
       
         return response()->json([
             'status' => '1',
             'message' => 'hotel added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of ' .config('global.max_day_for_repeating').' days',

            //  'message' => 'hotel added successfully',
            //  'hotel'=>$hotellll,
         ]);    
    }

    public function AcceptHotel(Request $req){
        // dd( config('app.name')2);
        $hotel_to_accept=Hotel::where('id',$req->id)->first();
        
        if($hotel_to_accept==null){
        return response()->json(['message'=>'hotel not exists','status'=>0],400);
        }
        // dd($hotel_to_accept->acceptable);
        if($hotel_to_accept->acceptable==1){
        return response()->json(['message'=>'allready accepted','status'=>0],400);
        }
        $hotel_to_accept->update(['acceptable'=>1]);
        $text='Congratulations your hotel '.$hotel_to_accept->name.' has been accepted in trip tips manage your project by';
        $details=[
            'body'=>$text,
            'link_to_web'=>'1'
        ]; 
        // dd();
               //بعتنا عل ايميل الدعم رسالة نجاح تسجيل المطعم بل برنامج عنا 
        Mail::to($hotel_to_accept->support_email)->send(new AcceptFacilities ($details));   
        return response()->json(['message'=>' email sent,and accept successfuly','status'=>1,'acceptable'=>$hotel_to_accept->acceptable],200);
    }

    public function RefusHotel(Request $req){

        $hotel_to_refus= Hotel::where('id',$req->id)->first();
        // dd($r);

        if($hotel_to_refus==null){
        return response()->json(['message'=>'hotel not exists','status'=>0],400);
        }
        if($hotel_to_refus->acceptable==1){
        return response()->json(['message'=>'this hotel is accepteble','status'=>0],400);
        }
        else{
            
            $text='Sorry your Hotel '.$hotel_to_refus->name.'  has been Refus by Admins Because your Hotel does not follow the conditions of society TripTips ';
            $details=[
                'body'=>$text,
                'link_to_web'=>0
            ];
            //بعتنا عل ايميل تبع اليوزر هاد الرمز 
        Mail::to($hotel_to_refus->support_email)->send(new AcceptFacilities ($details));   
        $res_name=$hotel_to_refus->name;
        File::deleteDirectory(public_path('storage/images/hotel/'.$res_name));
        HotelImages::where('hotel_id',$hotel_to_refus->id)->delete();
        $hotel_to_refus->delete();
        dd($hotel_to_refus->id);
        return response()->json(['message'=>'email sent,and refuse and delete information successfuly','status'=>1],200);
        }
    }

    public function ShowAllHotels(){

        $hotels_acceptable = Hotel::with('images','classes')->where('acceptable',1)->get();
 
         return response()->json(['message'=>' successfuly','hotels'=>$hotels_acceptable,'status'=>1],200);
   
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

}
