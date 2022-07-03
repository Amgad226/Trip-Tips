<?php
namespace App\Http\Controllers\Api\loging;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialiteLog extends Controller
{
function registerSocialite(Request $request){
    
    $user =User::with('role')->where('email',$request->email)->first();
        if($user!=null && $user->is_registered==1)
        {
            $token= $user->createToken('agadsdguas')->accessToken;

            return response()->json([
                'message' => 'User successfully registered',
                'token' => $token,
                'user' => $user
            ], 200);
 
        }
        else
        {
            if($user!=null && $user->is_registered==0)
            {
                unlink(substr( $user->img,1) );
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
                    'name'      =>$request->name,
                    'email'     => $request->email,
                    'img'       => $image_path,    
                    'is_verifaied'=>true,
                    'is_registered'=>0,
                ];
                // dd();
                $UserToDataBase = User::create($input);
                $id=$UserToDataBase->id;
                $user =User::with('role')->where('id',$id)->first(); 
            
                $token= $UserToDataBase->createToken('agadsdguas')->accessToken;
            
                 return response()->json([
                'message' => 'User successfully registered',                
                'token' => $token,
                'user' => $user
            ], 200);
        }
}   

            
        function addPasswordSocialite(Request $request){

            // $password= Hash::make($request->password); // with enconding password
            $password= Hash::make($request->password);
            $userId = Auth::id();
            // dd($userId);
    

            User::where('id',$userId)->update(['password' =>$password ,'is_registered'=>true]);
        
             return response()->json([ 'message' => 'Password successfully adding'], 200);
        }
        }