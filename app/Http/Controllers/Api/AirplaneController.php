<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AcceptFacilities;
use App\Models\Airplane\Airplane;
use App\Models\Airplane\AirplaneBooking;
use App\Models\Airplane\AirplaneClass;
use App\Models\Airplane\AirplaneComment;
use App\Models\Airplane\AirplaneRole;

use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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

         $airplane_role=AirplaneRole::create(['user_id'=>Auth::id(), 'airplane_id'=>$airplane->id,'role_facilities_id'=>1]);

         $Airplane_name=$airplane_role->airplane->name;
         $facilities_name=$airplane_role->facilitie->role_name;
   
         $airplane_role->airplane_name=$Airplane_name;
         $airplane_role->role_facilities_name=$facilities_name;
         $airplane_role->save();
         
         $classes=$request->classes;
         $names=$request->names;
         for ($i=0;$i<count($classes);$i++)
         {
         AirplaneClass::create(['airplane_id'=>$airplane->id,'money'=>$classes[$i],'class_name'=>$names[$i]]);

         }
      
        
        //  $airplanett=airplane::where('id',$airplane->id)->first();
         //  dd($airplanett);
       
         return response()->json([
             'status' => 1,
             'message' => 'airplane added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of '.config('global.max_day_for_repeating').' days',
             'id'=>$airplane->id,
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
               //?????????? ??+?? ?????????? ?????????? ?????????? ???????? ?????????? ???????? ?????????????? ???? ???????????? ?????? 
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
            //?????????? ???? ?????????? ?????? ???????????? ?????? ?????????? 
        Mail::to($airplane_to_refuse->support_email)->send(new AcceptFacilities ($details));   
        if($req->id!=1)
         { 
            //???????? ???? ?????????? ???????????? ???? ???????? ???????? ???????????? ?? ???????? ???????????? ?????????????? ?????????????? 
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

    public function Show_Not_Active_Airplanes(){

        $airplane_acceptable = Airplane::with('classes')->where('acceptable',0)->get();
 
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
            'unique'          =>Str::random(16)


           ];
        $BookingAirplane = AirplaneBooking::create($data);
    

        $token = Str::random(4);

        $image = QrCode::color(0, 36, 63)->format('png')->merge(public_path('default_photo/logo.png'), .3, true)
        ->size(500)
        ->generate('http://127.0.0.1:8000/api/booking-info/'.$BookingAirplane->user_id.'/'.$token.'/'.$BookingAirplane->id.'/'.$BookingAirplane->unique.'?type=air');

        
        Storage::disk('local')->makeDirectory('public/images/airplane/'.$BookingAirplane->airplane->name.'/qr');

        $a='public/images/airplane/'.$BookingAirplane->airplane->name.'/qr/'.Auth::user()->name.time().'.png';
        $link_qr_in_public='/storage/images/airplane/'.$BookingAirplane->airplane->name.'/qr/'.Auth::user()->name.time().'.png';
        $BookingAirplane->img_qr=$link_qr_in_public;
        $BookingAirplane->save();
        Storage::disk('local')->put($a, $image);  
        
 


        return response()->json([
            'status' => 1,
            'message' => 'BookingAirplane added successfully ,go to your profile to get image Qr code ',
            // 'info'=>$BookingAirplane,
        ]);    
    }

    public function add_Airplane_Comment(Request $request) {


        $validator = Validator::make($request-> all(),[
           
            'airplane_id'     =>  ['required', 'exists:airplanes,id'],
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
                    'airplane_id'         => $request->airplane_id,
                    'comment'             => $request->comment,                
                ];
      $comment=AirplaneComment::create($data_of_comment);

        return response()->json([
            'status' => 1,
            'message'=>'Your comment has been added',
            'id' => $comment->id

        ]); 
    }
    
    public function remove_Airplane_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>  ['required', 'exists:airplane_comments,id'],
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

         $comment=AirplaneComment::where('id',$request->comment_id)->first();
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
    public function Show_Airplane_Comments(Request $request){

        $validator = Validator::make($request-> all(),[

            'airplane_id'      =>  ['required', 'exists:airplanes,id'],
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

        $comments = AirplaneComment::with('user')->where('airplane_id',$request->airplane_id)->get();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comments   ]));
    } 

    public function Show_Airplane_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>['required', 'exists:airplane_comments,id'],
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

        $comment = AirplaneComment::with('user')->where('id',$request->comment_id)->first();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comment   ]));
    } 

}