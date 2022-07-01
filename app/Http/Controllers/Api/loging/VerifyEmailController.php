<?php

namespace App\Http\Controllers\Api\loging;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    
    public function verify($id) {
        
    
      $user=User::where('id',$id)->first();
      if ($user==null)
      {
        $text='user not found in ';
        return view('thanks_for_verifaied',["text"=>$text]);
      }
      if($user->is_verifaied==0){
          $text='Thanks for verification in ';
          User::where('id',$id)->update(['is_verifaied' => 1]);
          return view('thanks_for_verifaied', ["text"=>$text]);
        }
        else
        $text='You allready verification in ';
      return view('thanks_for_verifaied',["text"=>$text]);

      
    }

    public function resend() {

        request()->user()->sendEmailVerificationNotification();

        return response()->json(['message'=> 'Email has been sent!'],200);
    }


    public function Verify_checking()  {

        $user=Auth::user();
        // dd($user);
        if($user->is_verifaied==0){
        return response()->json([
            'message'=> 'email was not verified!',
            'is_verifaied' => $user->is_verifaied,
         ],200);
        }
        return response()->json([
            'message'=> 'email is verified!',
            'is_verifaied' => $user->is_verifaied,
         ],200);
    }
}