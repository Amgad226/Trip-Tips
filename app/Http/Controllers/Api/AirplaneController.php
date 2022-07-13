<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AcceptFacilities;
use App\Models\Airplane\Airplane;
use App\Models\Airplane\AirplaneBooking;
use App\Models\Airplane\AirplaneClass;
use App\Models\Airplane\AirplaneRole;

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

    public function addAirplane(Request $request){
        $validator = Validator::make($request-> all(),[
            'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:20','min:3'],
            'location'      => 'required',
            'support_email' => 'required|email',
            'img_title_deed'=> 'required',
            'description'   => 'required',

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
            $extension='.'.$request->img_title_deed->getclientoriginalextension();
            
            
            if(!in_array($extension, config('global.allowed_extention')))
            {
                return response()->json(['status'=>0,'message' => 'invalide image ectension' ]);   
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
            'description'   =>$request->description,
           ];
         $airplane = Airplane::create($data);
         DB::table('users')->where('id',Auth::id())->update(['have_facilities' =>1]);
         AirplaneRole::create(['user_id'=>Auth::id(),'airplane_id'=>$airplane->id,'role_facilities_id'=>1]);
         $classes=$request->classes;
         $names=$request->names;
         for ($i=0;$i<count($classes);$i++)
         {
         AirplaneClass::create(['airplane_id'=>$airplane->id,'money'=>$classes[$i],'class_name'=>$names[$i]]);

         }
      
        
        //  $airplanett=airplane::where('id',$airplane->id)->first();
         //  dd($airplanett);
       
         return response()->json([
             'status' => '1',
             'message' => 'airplane added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of '.config('global.max_day_for_repeating').' days',
            //  'airplane'=>$airplanett,
         ]);      
    }

    public function AcceptAirplane(Request $req){
        // dd( config('app.name')2);
        $airplene_to_accept=Airplane::where('id',$req->id)->first();
        
        if($airplene_to_accept==null){
        return response()->json(['message'=>'airplane not exists','status'=>0],400);
        }
        // dd($airplene_to_accept->acceptable);
        if($airplene_to_accept->acceptable==1){
        return response()->json(['message'=>'allready accepted','status'=>0],400);
        }
        $airplene_to_accept->update(['acceptable'=>1]);
        $text='Congratulations your Airplane '.$airplene_to_accept->name.' has been accepted by .'.Auth::user()->name.'. admin in trip tips manage your project by';
        $details=[
            'body'=>$text,
            'link_to_web'=>'1'
        ];
        // dd();
               //بعتنا ع+ل ايميل الدعم رسالة نجاح تسجيل شركة الطيران بل برنامج عنا 
        Mail::to($airplene_to_accept->support_email)->send(new AcceptFacilities ($details));   
        return response()->json(['message'=>' email sent,and accept successfuly','status'=>1,'acceptable'=>$airplene_to_accept->acceptable],200);
    }

    public function RefusAirplane(Request $req){

        $airplane_to_refuse= Airplane::where('id',$req->id)->first();

        if($airplane_to_refuse==null){
        return response()->json(['message'=>'airplane not exists','status'=>0],400);
        }
        if($airplane_to_refuse->acceptable==1){
        return response()->json(['message'=>'this airplane is accepteble','status'=>0],400);
        }
        else{
            
            $text='Sorry your airplane '.$airplane_to_refuse->name.'  has been Refus by Admins Because your restaurant does not follow the conditions of society TripTips ';
            $details=[
                'body'=>$text,
                'link_to_web'=>0
            ];
            //بعتنا عل ايميل تبع اليوزر هاد الرمز 
        Mail::to($airplane_to_refuse->support_email)->send(new AcceptFacilities ($details));   
        if($req->id!=1)
         { 
            //لانو هي لشركة ضايفها بل سيدر مشان التيست و بغير مجلدات التخزين الطبيعي 
             $res_name=$airplane_to_refuse->name;
             File::deleteDirectory(public_path('storage/images/airplane/'.$res_name));
         }
        // Airplane::where('airplane_id',$airplane_to_refuse->id)->delete();
        $airplane_to_refuse->delete();
        return response()->json(['message'=>'email sent,and refuse and delete information successfuly','status'=>1],200);
        }
    }

    public function ShowAllAirplane(){

        $airplane_acceptable = Airplane::with('classes')->where('acceptable',1)->get();
 
         return response()->json(['message'=>' successfuly','airplane'=>$airplane_acceptable,'status'=>1],200);
   
    }

    public function add_Airplane_Booking(Request $request){
       
      
        $validator = Validator::make($request-> all(),[
            'airplane_id'      => 'required',
            'airplane_class_id'=> 'required',
            'from'             => 'required',
            'to'               => 'required',
            'date'             => 'required',
            'number_of_people' => 'required',
            'price'            => 'required',
            // 'booking_date'    => 'required|date',
            // 'note'            => 'required',
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
           $people=$request->number_of_people;
           $price=$request->price;
           $price=$price*$people;
        // dd(Auth::id());
        $data = [
            'airplane_id'      => $request->airplane_id,
            'airplane_class_id'=> $request->airplane_class_id,
            'user_id'          => Auth::id(),
            'from'             => $request->from,
            'to'               => $request->to,
            'number_of_people' =>$request->number_of_people,
            'price'            =>$price,
            'date'             =>$request->date,
            'note'             =>$request->note,
            'by_packge'        =>0,

           ];
        $BookingAirplane = AirplaneBooking::create($data);
    
        return response()->json([
            'status' => '1',
            'message' => 'BookingAirplane added successfully ,go to your profile to get image Qr code ',
            'info'=>$BookingAirplane,
        ]);    
    }

}