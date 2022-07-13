<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Mail\AcceptFacilities;
use App\Models\Place\PlaceRole;
use App\Models\Place\Place;
use App\Models\Place\PlaceImage;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use  Image;

class PlaceController extends Controller
{

    public function addPlace(Request $request){   

            $validator = Validator::make($request-> all(),[
            'name'          => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'max:20','min:3'],
            'location'      => 'required',
            'support_email' => 'required|email',
            'img_title_deed'=> 'required',
            'description'   => 'required',
            'img'           => 'required',
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
            $place_Name= $request->name;  
            Storage::disk('local')->makeDirectory('public/images/place/'.$place_Name);
            Storage::disk('local')->makeDirectory('public/images/place/'.$place_Name."/title_deed");
            $uniqid='('.uniqid().')';   
            $destination_path = 'public/images/place/'.$place_Name."/title_deed";   
            //store with resize
            $image=$request->file('img_title_deed') ; 
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
            $image_resize->save(public_path("/storage/images/place/".$place_Name.'/title_deed/'.$place_Name.$extension ));
            //store without resize 
            // $request->file('img_title_deed')->storeAs($destination_path,   $uniqid.$place_Name.$extension);  

            $image_title_deed_path = "/storage/images/place/".$place_Name.'/title_deed/'. $place_Name.$extension;        
         
         
         $data = [
            'user_id'       =>Auth::id(),
            'name'          => $request->name,
            'location'      => $request->location,
            'Payment'       => config('global.Payment_place'),
            'support_email' => $request->support_email,
            'img_title_deed'=> $image_title_deed_path, 
            'description'   =>$request->description,

           ];
           
         $place = Place::create($data);
         PlaceRole::create(['user_id'=>Auth::id(),'place_id'=>$place->id,'role_facilities_id'=>1]);
         DB::table('users')->where('id',Auth::id())->update(['have_facilities' =>1]);
        // dd();
        //  $data = [];

         $images_place=$request->img;
         $i=1;
         // return($request->img);
         foreach($images_place as $image_place) 
         {   
                // dd(json_decode($image_place));
                // dd($image_place);
                $extension='.'.$image_place->getclientoriginalextension();
            // $a='fkdjhfksdh.dd';
            // dd($a->getclientoriginalextension());
                 if(!in_array($extension, config('global.allowed_extention')))
                 {
                    // File::deleteDirectory(public_path('storage/a'));
                    File::deleteDirectory(public_path('storage/images/place/'.$request->name));
                    PlaceImage::where('place_id',$place->id)->truncate();
                    $place->delete();

                     return response()->json(['message' => 'place doesnot regeistered because you enter invalide image ectension' ]);   
                 }
                $destination_path ='public/images/place/'.$place_Name; //غير مستعمل

                //store with resize
                $image=$image_place ; 
                $image_resize = Image::make($image->getRealPath());      
                // dd($image_resize);        
                $image_resize->resize(500, 500, function ($constraint) {$constraint->aspectRatio(); });
                $image_resize->save(public_path("/storage/images/place/".$place_Name ."/". $i."_".$place_Name.$extension ));

                //store without resize
                // $image_place->storeAs($destination_path,  $i."_". $place_Name.$extension);  

                $image_path_to_database = "/storage/images/place/".$place_Name ."/". $i."_".$place_Name.$extension;        
                $image_data=['img'=>$image_path_to_database,'place_id'=>$place->id];
                PlaceImage::create($image_data);
                 $i++;
                
            
        }
      
       
         return response()->json([
             'status' => '1',
             'message' => 'place added in our datebase successfully ,we will send the anwer to your suppurt email within a maximum time of ' .config('global.max_day_for_repeating').' days',

            //  'place'=>$placett,
         ]);     
    }

    public function AcceptPlace(Request $req){
        // dd( config('app.name')2);
        $place_to_accept=Place::where('id',$req->id)->first();
        
        if($place_to_accept==null){
        return response()->json(['message'=>'restaurant not exists','status'=>0],400);
        }
        // dd($place_to_accept->acceptable);
        if($place_to_accept->acceptable==1){
        return response()->json(['message'=>'allready accepted','status'=>0],400);
        }
        $place_to_accept->update(['acceptable'=>1]);
        $text='Congratulations your placce '.$place_to_accept->name.' has been accepted in trip tips manage your project by';
        $details=[
            'body'=>$text,
            'link_to_web'=>'1'
        ]; 
        // dd();
               //بعتنا عل ايميل الدعم رسالة نجاح تسجيل المطعم بل برنامج عنا 
        Mail::to($place_to_accept->support_email)->send(new AcceptFacilities ($details));   
        return response()->json(['message'=>' email sent,and accept successfuly','status'=>1,'acceptable'=>$place_to_accept->acceptable],200);
    }

    public function RefusPlace(Request $req){

        $place_to_refuse= Place::where('id',$req->id)->first();
        // dd($r);

        if($place_to_refuse==null){
        return response()->json(['message'=>'place not exists','status'=>0],400);
        }
        if($place_to_refuse->acceptable==1){
        return response()->json(['message'=>'this place is accepteble','status'=>0],400);
        }
        else{
            
            $text='Sorry your Place '.$place_to_refuse->name.'  has been Refus by Admins Because your place does not follow the conditions of society TripTips ';
            $details=[
                'body'=>$text,
                'link_to_web'=>0
            ];
            //بعتنا عل ايميل تبع اليوزر هاد الرمز 
        Mail::to($place_to_refuse->support_email)->send(new AcceptFacilities ($details));   
        $res_name=$place_to_refuse->name;
        File::deleteDirectory(public_path('storage/images/place/'.$res_name));
        PlaceImage::where('place_id',$place_to_refuse->id)->delete();
        $place_to_refuse->delete();
        return response()->json(['message'=>'email sent,and refuse and delete information successfuly','status'=>1],200);
        }
    }

    public function ShowAllPlaces(){

        $place_acceptable = Place::with('image')->where('acceptable',1)->get();
 
         return response()->json(['message'=>' successfuly','Place'=>$place_acceptable,'status'=>1],200);
   
    }
    
    public function Show_Not_Active_Places(){

        $place_acceptable = Place::with('image')->where('acceptable',0)->get();
 
         return response()->json(['message'=>' successfuly','Place'=>$place_acceptable,'status'=>1],200);
   
    }

    
    
}
