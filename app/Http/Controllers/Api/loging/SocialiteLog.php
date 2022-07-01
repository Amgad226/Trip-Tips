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
function requestTokenGoogle(Request $request){
    // Getting the user from socialite using token from google
    $UserFormGoogle = Socialite::driver('google')->stateless()->userFromToken($request->token);
    // dd();
            if (!$UserFormGoogle)
            {
                return response()->json('You do not have access to this email ',400);
            }
    
            $UserToDataBase = User::create(
                [
                    'name'=>$UserFormGoogle->name,
                    'email' => $UserFormGoogle->email,
                    'img'=>$UserFormGoogle->avatar,
                    'is_verifaied'=>true,
                ]);
            $id=$UserToDataBase->id;
            $user =User::where('id',$id)->first(); 
            $token= $UserToDataBase->createToken('agadsdguas')->accessToken;
    
             return response()->json([
            'Message' => 'User successfully registered',
            'token' => $token,
            'user' => $user
            ], 200);}
               // _________________________________________________________________________________
        function requestTokenFacebook(Request $request){
            // dd();
            // Getting the user from socialite using token from google
             $UserFormFacebook =  Socialite::driver('facebook')->stateless()->userFromToken($request->token);
            dd($UserFormFacebook);

            if (!$UserFormFacebook)
            {
                return response()->json('You do not have access to this email ',400);
            }
    
            $UserToDataBase = User::create(
                [
                    'email' => $UserFormFacebook->email,
                    'name'=>$UserFormFacebook->name,
                    'img'=>$UserFormFacebook->avatar,
                    'is_verifaied'=>true,
    
                  
                ]);
            $id=$UserToDataBase->id;
            $user =User::where('id',$id)->first(); 
            $token = $UserToDataBase->createToken('amgad226')->accessToken;
    
             return response()->json([
            'Message' => 'User successfully registered',
            'token' => $token,
            'user' => $user
            ], 200);
        }
            
        function addPasswordSocialite(Request $request){

            // $password= Hash::make($request->password); // with enconding password
            $password= $request->password;
            $userId = Auth::id();
            // dd($userId);
            User::where('id',$userId)->update(['password' =>$password]);
        
             return response()->json([ 'Message' => 'Password successfully adding',], 200);
        }
        }