<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AcceptFacilities;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelImages;
use App\Models\Hotel\HotelBooking;
use App\Models\Hotel\HotelClass;
use App\Models\Hotel\HotelComment;
use App\Models\Hotel\HotelRole;

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
            'img'           => 'required',
            'description'           => 'required',
            'category_id'    =>    ['required', 'exists:catigories_hotel,id'],

            
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
             return response()->json(['message' => 'invalide image ectension' ,'status' => 0],400);   
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
            'description'=>$request->description,
            'category_id'   =>$request->category_id,

           ];
         $hotel = Hotel::create($data);
         DB::table('users')->where('id',Auth::id())->update(['have_facilities' =>1]);
         $hotel_role=HotelRole::create(['user_id'=>Auth::id() , 'hotel_id'=>$hotel->id,'role_facilities_id'=>1]);

         $Hotel_name=$hotel_role->hotel->name;
         $facilities_name=$hotel_role->facilitie->role_name;
 
         $hotel_role->hotel_name=$Hotel_name;
         $hotel_role->role_facilities_name=$facilities_name;
         $hotel_role->save();
         
         $images_hotel=$request->img;
        //  dd($images_hotel)
         
         if($request->hasFile('img'))
           {   
             $i=1;
             foreach($images_hotel as $image_hotel) 
               {     
                   $extension='.'.$image_hotel->getclientoriginalextension();
                   if(!in_array($extension, config('global.allowed_extention')))
                   {
                       File::deleteDirectory(public_path('storage/images/hotel/'.$request->name));
                       HotelImages::where('hotel_id',$hotel->id)->delete();
                       $hotel->delete();
  
                       return response()->json(['message' => 'hotel doesnot regeistered because you enter invalide image ectension','status' => 0 ],400);   
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
                   $i++;
                
                }
           }
            //?????????? ???????????? ???????????? ???????????????? 
         $classes=$request->classes;
         $names=$request->names;
         $number_of_people=$request->number_of_people;
         for ($i=0;$i<count($classes);$i++)
         {
           HotelClass::create(['hotel_id'=>$hotel->id,'money'=>$classes[$i],'class_name'=>$names[$i],'number_of_people'=>$number_of_people[$i] ,]);
         }
          //  $hotellll=Hotel::with('images')->where('id',$hotel->id)->first();
         //  dd($hoteltt);
       
         return response()->json([
             'status' => 1,
             'message' => 'hotel added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of ' .config('global.max_day_for_repeating').' days',
            'id'=>$hotel->id,
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
               //?????????? ???? ?????????? ?????????? ?????????? ???????? ?????????? ???????????? ???? ???????????? ?????? 
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
            //?????????? ???? ?????????? ?????? ???????????? ?????? ?????????? 
        Mail::to($hotel_to_refus->support_email)->send(new AcceptFacilities ($details));   
        $res_name=$hotel_to_refus->name;
        File::deleteDirectory(public_path('storage/images/hotel/'.$res_name));
        HotelImages::where('hotel_id',$hotel_to_refus->id)->delete();
        $hotel_to_refus->delete();
        // dd($hotel_to_refus->id);
        return response()->json(['message'=>'email sent,and refuse and delete information successfuly','status'=>1],200);
        }
    }

    public function ShowAllHotels(){

        $hotels_acceptable = Hotel::with('images','classes','category')->where('acceptable',1)->get();
 
         return response()->json(['message'=>' successfuly','hotels'=>$hotels_acceptable,'status'=>1],200);
   
    }

    public function Show_Not_Active_Hotels(){

        $hotels_acceptable = Hotel::with('images','classes','category')->where('acceptable',0)->get();
 
         return response()->json(['message'=>' successfuly','hotels'=>$hotels_acceptable,'status'=>1],200);
   
    }

    public function add_Hotel_Booking(Request $request)
    {
        $validator = Validator::make($request-> all(),[
            'number_of_people'=> 'required',
            'hotel_id'   => 'required',
            'hotel_class_id'   => 'required',
            'price'           => 'required',
            'start_date'    => 'required|date',
            'end_date'    => 'required|date',

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
            // $start_time = \Carbon\Carbon::parse($request->input('start_date'));
            // $finish_time = \Carbon\Carbon::parse($request->input('end_date'));
            // $result = $start_time->diffInDays($finish_time, false);
            // echo '  ?????? ???????? ??????????         . ' .  $result ."\n";
            // $price=$request->price;
            // echo '  ?????????? ?????? ???????? ???? ??????????????????           . '.  $price ."\n";
            // $room=$request->number_of_room;
            // echo '  ?????? ??????????               .'  .$room ."\n";
            // $price=$price*$room*$result;
            // echo '  ?????? ???????? ?????????? * ?????? ?????????? *??????????            .'. $price;
            // return;

        $data = [
            'hotel_id'        => $request->hotel_id,
            'hotel_class_id'  => $request->hotel_class_id,
            'user_id'         => Auth::id(),
            'number_of_people'=>$request->number_of_people,
            'number_of_room'  =>$request->number_of_room,
            'price'           =>$request->price,
            'start_date'      =>$request->a,
            'end_date'        =>$request->end_date,
            'note'            =>$request->note,
            'by_packge'       =>0,
            'unique'          =>Str::random(16)

           ];
            $BookingHotel = HotelBooking::create($data);
            $BookingHotel->start_date=$request->start_date;
            $BookingHotel->save();


            $token = Str::random(4);

            $image = QrCode::color(0, 36, 63)->format('png')->merge(public_path('default_photo/logo.png'), .3, true)
            ->size(500)
            ->generate('http://127.0.0.1:8000/api/booking-info/'.$BookingHotel->user_id.'/'.$token.'/'.$BookingHotel->id.'/'.$BookingHotel->unique.'?type=hot');
    
            
            Storage::disk('local')->makeDirectory('public/images/hotel/'.$BookingHotel->hotel->name.'/qr');
    
            $a='public/images/hotel/'.$BookingHotel->hotel->name.'/qr/'.Auth::user()->name.time().'.png';
            $link_qr_in_public='/storage/images/hotel/'.$BookingHotel->hotel->name.'/qr/'.Auth::user()->name.time().'.png';
            $BookingHotel->img_qr=$link_qr_in_public;
            $BookingHotel->save();
            Storage::disk('local')->put($a, $image);  
            

        return response()->json([
            'status' => 1,
            'message' => 'BookingHotel added successfully ,go to your profile to get image Qr code ',
        ]);      
  
 

    

    }

    public function add_Hotel_Comment(Request $request) {


        $validator = Validator::make($request-> all(),[
           
            'hotel_id'     =>  ['required', 'exists:hotels,id'],
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
                    'hotel_id'             => $request->hotel_id,
                    'comment'             => $request->comment,                
                ];
        $comment=  HotelComment::create($data_of_comment);

        return response()->json([
            'status' => 1,
            'message'=>'Your comment has been added',
            'id'=>$comment->id,
        ]); 
    }
    
    public function remove_Hotel_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'Comment_id'      =>  ['required', 'exists:hotel_comments,id'],
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

         $comment=HotelComment::where('id',$request->Comment_id)->first();
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
    public function Show_Hotel_Comments(Request $request){

        $validator = Validator::make($request-> all(),[

            'hotel_id'      =>  ['required', 'exists:hotels,id'],
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

        $comments = HotelComment::with('user')->where('hotel_id',$request->hotel_id)->get();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comments   ]));
    } 


    public function Show_Hotel_Comment(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>['required', 'exists:hotel_comments,id'],
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

        $comment = HotelComment::with('user')->where('id',$request->comment_id)->first();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comment   ]));
    } 

}
