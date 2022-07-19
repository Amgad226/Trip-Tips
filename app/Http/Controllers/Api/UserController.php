<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\AppReview;
use App\Models\TouristSupervisor;
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
        $name=$user->roles->role_name;
        $user->role_peson_name=$name;
        $user->save();
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
        $name=$user->roles->role_name;
        $user->role_peson_name=$name;
        $user->save();

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
            if ($user->is_active==1)
            {
                // dd();
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

    public function unBlock(Request $req){   

       
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
            if ($user->is_active==0)
            {
                if($user->role_person_id<3)
                {
                     $user->is_active=1;
                     $user->save();        
                     return response()->json([
                         'status' => 1,
                         'message' => 'done',
                         'users'=> $user, 
                     ]);  
              } 
            }
        }

        if ($user->is_active==1)
        {
             return response()->json([
            'status' => 0,
            'message' => 'allready unblocked ',
           ]); 

        }
        

        if($user->role_person_id<2)
        {
            $user->is_active=1;
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

    public function addCommentForApp(Request $req){   

        
        $validator = Validator::make($req-> all(),['comment'=>['required'],]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }

        AppReview::create(['comment'=>$req->comment,'user_id'=>Auth::id()]);
     
         return response()->json([
             'status' => 1,
             'message' => 'done',
             
         ]);     
    }

    public function delleteCommentForApp(Request $req){   

        
        $validator = Validator::make($req-> all(),['comment_id'=>['required', 'exists:app_reviews,id'],]);
        if ($validator->fails())
        {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json( ['message'=>$errors['message'],'status'=>0],400);
        }


        $comment=AppReview::where('id',$req->comment_id)->first();
        if(Auth::user()->role_person_id>1||$comment->user_id==Auth::id())
        {
            $comment->delete();
            return response()->json([
                'status' => 1,
                'message'=>'comment has been deleted'
            ]);
        }

     return response()->json([
        'status' => 0,
        'message' => 'access denied' ]); 
    }
    
    
    public function Show_Comments_For_App(){

        $comments = AppReview::with('user')->get();
            return( response()->json([ 
                'status'=>1,
                'message'=> $comments   ]));
    } 

    public function Show_Comment_For_App(Request $request){

        $validator = Validator::make($request-> all(),[

            'comment_id'      =>['required', 'exists:app_reviews,id'],
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

        $comment = AppReview::with('user')->where('id',$request->comment_id)->first();
        //  dd($comments);
            return( response()->json([ 
                'status'=>1,
                'message'=> $comment   ]));
    } 
        



    
}
