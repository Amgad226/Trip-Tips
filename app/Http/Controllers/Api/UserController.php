<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function getAll(){   

        $users=User::with('RestaurantRole','HotelRole','AirplaneRole','PlaceRole')->get();
     
            return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $users,

         ]);     
    }

    public function getNewUser(){   

        $users=User::with('RestaurantRole','HotelRole','AirplaneRole','PlaceRole')->where('time',date('Y-m-d'))->get();
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $users,
             
         ]);     
    }

    public function getOwner(){   

        $users=User::with('RestaurantRole','HotelRole','AirplaneRole','PlaceRole')->where('role_person_id',3)->get();
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $users,
             
         ]);     
    }

    public function getAdmins(){   

        $users=User::with('RestaurantRole','HotelRole','AirplaneRole','PlaceRole')->where('role_person_id',2)->get();
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $users,
             
         ]);     
    }

    public function getUsers(){   

        $users=User::with('RestaurantRole','HotelRole','AirplaneRole','PlaceRole')->where('role_person_id',1)->get();
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $users,
             
         ]);     
    }

    public function UnActive(){   

        $users=User::with('RestaurantRole','HotelRole','AirplaneRole','PlaceRole')->where('is_active',0)->get();
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $users,
             
         ]);     
    }

    public function PromotionToAdmin(Request $req){

        $validator = Validator::make($req-> all(),['user_id'=>['required', 'exists:users,id'],]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }

        $user=User::where('id',$req->user_id)->first();
        if($user->role_person_id==3)
        {
            return response()->json([
            'status' => 0,
            'message' => 'you dont have permission ',
           ]);  
        }
        if($user->role_person_id==2)
        {
            return response()->json([
            'status' => 0,
            'message' => 'allready admin ',
           ]);  
        }
       
        $user->update(['role_person_id'=>2]);
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $user, 
         ]);     
    }

    public function DemotionToUser(Request $req){   

        $validator = Validator::make($req-> all(),['user_id'=>['required', 'exists:users,id'],]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }

        $user=User::where('id',$req->user_id)->first();

        if($user->role_person_id==3)
        {
            return response()->json([
            'status' => 0,
            'message' => 'you dont have permission ',
           ]);  
        }
        if($user->role_person_id==1)
        {
            return response()->json([
            'status' => 0,
            'message' => 'allready user ',
           ]);  
        }

       
        $user->update(['role_person_id'=>1]);
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             'users'=> $user, 
         ]);       
    }

    public function Delete(Request $req){   

        $validator = Validator::make($req-> all(),['user_id'=>['required', 'exists:users,id'],]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }

        $user=User::where('id',$req->user_id)->first();

        
        if(Auth::user()->role_person_id==3){
            if($user->role_person_id<3)
            {
                $user->delete();
        
                return response()->json([
                    'status' => 1,
                    'message' => 'done',
                    'users'=> $user, 
                ]);  
            }
            else
            {
                return response()->json([
                    'status' => 0,
                    'message' => 'you dont have permission to delete your self  you are the owner',
                   ]); 
            }
        }
        if(Auth::user()->id==$req->user_id){
          
                $user->delete();
        
                return response()->json([
                    'status' => 1,
                    'message' => 'thank you for work with us',
                    'users'=> $user, 
                ]);  
            
        }


        if($user->role_person_id==1)
        {

            $user->delete();
     
            return response()->json([
                'status' => 1,
                'message' => 'done',
                'users'=> $user, 
            ]); 
        }
     
      
        else{
        return response()->json([
            'status' => 0,
            'message' => 'you dont have permission ',
           ]);  
      
        }
            
    }

    public function Block(Request $req){   

       
        $validator = Validator::make($req-> all(),['user_id'=>['required', 'exists:users,id'],]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }
        $user=User::where('id',$req->user_id)->first();

        if(Auth::id()==$req->user_id){  
            return response()->json([
            'status' => 0,
            'message' => 'you dont have permission to block your self ',
           ]);  
        }
        if(Auth::user()->role_person_id==3){
            if ($user->is_active!=1)
            {
                if($user->role_person_id<3)
                {
                     $user->is_active=0;
                     $user->save();        
                     return response()->json([
                         'status' => 1,
                         'message' => 'done',
                         'users'=> $user, 
                     ]);  
              } 
            }
        }

        if ($user->is_active!=1)
        {
             return response()->json([
            'status' => 0,
            'message' => 'allready blocked ',
           ]); 

        }

        if($user->role_person_id<2)
        {
            $user->is_active=0;
            $user->save();
            return response()->json([
                'status' => 1,
                'message' => 'done',
                'users'=> $user, 
            ]); 
        }
     
       else{
        return response()->json([
            'status' => 0,
            'message' => 'you dont have permission ',
           ]);  
      
        }
    
    }    




    public function qr(Request $re){

        $id=7;//request->id
        $id_item=1;//request->name
        $a=User::where('id',$id)->first();
        $item=Item::where('id',$id_item)->first();
   
           $image = QrCode::format('png')
                    ->generate('http://127.0.0.1:8000/ss/'.$a->id.'.'.$a->unque.'.'.$item->id.'.'.$item->unquee);
         $output_file = '/img/qr-code/img-' . time() . '.png';
         Storage::disk('local')->put($output_file, $image);
         return  response()->json(
             ['msg'=>'QR CODE stored successfully']
           );
   }
   
}
