<?php
namespace App\Http\Controllers\Api\loging;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SocialiteLog extends Controller
{
function registerSocialite(Request $request){
    
    $user =User::with('roles')->where('email',$request->email)->first();
        if($user!=null && $user->is_registered==1)
        {
            $token= $user->createToken('agadsdguas')->accessToken;

            return response()->json([
                'status'=>1,
                'message' => 'User successfully registered',
                'token' => $token,
                'user' => $user,
            ], 200);
 
        }
        else
        {
            if($user!=null && $user->is_registered==0)
            {
                if($user->img!='/default_photo/user_default.png')
                {
                    unlink(substr( $user->img,1) );
                }
                $user->delete();     
            }
                if($request->img!=null)
                { 
                    // dd($UserFormGoogle->avatar);
                    $uniqid='('.uniqid().')';         
                    $image = file_get_contents($request->img);
                    file_put_contents(public_path('/storage/images/users/'.$uniqid.$request->name.'a.png'), $image);        
                    $image_path = "/storage/images/users/".$uniqid.$request->name.'a.png';       
                }
                else
                {
                   $image_path='/default_photo/user_default.png' ;
                }   
                $input = [
                    'name'         =>$request->name,
                    'email'        =>$request->email,
                    'img'          =>$image_path,    
                    'is_verifaied' =>true,
                    'is_registered'=>0,
                    'time'=>date('Y-m-d'),

                ];
                // dd();
                $UserToDataBase = User::create($input);
                $id=$UserToDataBase->id;
                $user =User::with('RestaurantRole','HotelRole','AirplaneRole')->where('email',$request->email)->first(); 
                $a=$user->roles->role_name;
                // dd($a);
                $user->role_peson_name=$a;
                $user->save();

                $token= $UserToDataBase->createToken('agadsdguas')->accessToken;
            
                 return response()->json([
                'status'=>1,
                'message' => 'User successfully registered',                
                'token' => $token,
                'user' => $user,
            ], 200);
        }
}   

            
        function addPasswordSocialite(Request $request){

            $validator = Validator::make($request-> all(),[
                'password'   => ['required', 'string', 'min:4'],
                'c_password' => 'required|same:password',
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
            // $password= Hash::make($request->password); // with enconding password
            $password= Hash::make($request->password);
            $userId = Auth::id();
            // dd($userId);
    

            User::where('id',$userId)->update(['password' =>$password ,'is_registered'=>true]);
        
             return response()->json([ 'status'=>1,'message' => 'Password successfully adding'], 200);
        }
        }