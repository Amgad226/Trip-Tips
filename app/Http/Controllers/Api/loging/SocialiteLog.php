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
            return response()->json([
                'message' => 'You do not have access to this email',

               ], 400);         
            }
          
            if($UserFormGoogle->avatar!=null)
            { 
                // dd($UserFormGoogle->avatar);
                $uniqid='('.uniqid().')';         
                $imaged = file_get_contents($UserFormGoogle->avatar);
                file_put_contents(public_path('/storage/images/users/'.$uniqid.$UserFormGoogle->name.'a.png'), $imaged);

                $destination_path = 'public/images/users';    
                // $imaged->storeAs($destination_path,$uniqid.$UserFormGoogle->avatar->getClientOriginalName()); 
                
                $image_path = "/storage/images/users/".$uniqid.$UserFormGoogle->name.'a.png';       
            }
             else
             {
                $image_path='/default_photo/user_default.png' ;
             }
             $input = [
                'name'      =>$UserFormGoogle->name,
                'email'     => $UserFormGoogle->email,
                'phone'     => $request->phone,
                'is_verifaied'=>true,
                'img'       => $image_path,   //هون حطيت باث الصورة يلي بل بابليك مشان يكون بل داتا بيز الباث يلي بينعرض  
          ];
            $UserToDataBase = User::create($input);
            $id=$UserToDataBase->id;
            $user =User::with('role')->where('id',$id)->first(); 

            $token= $UserToDataBase->createToken('agadsdguas')->accessToken;
    
             return response()->json([
            'message' => 'User successfully registered',
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
            return response()->json([
                'message' => 'You do not have access to this email',

               ], 400);         
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
            'message' => 'User successfully registered',
            'token' => $token,
            'user' => $user
            ], 200);
        }
            
        function addPasswordSocialite(Request $request){

            // $password= Hash::make($request->password); // with enconding password
            $password= Hash::make($request->password);
            $userId = Auth::id();
            // dd($userId);
            User::where('id',$userId)->update(['password' =>$password]);
        
             return response()->json([ 'message' => 'Password successfully adding',], 200);
        }
        }