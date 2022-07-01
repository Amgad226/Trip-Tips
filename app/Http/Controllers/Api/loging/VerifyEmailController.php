<?php

namespace App\Http\Controllers\Api\loging;

use App\Models\User;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{
    
    public function verify($id) {
      
        User::where('id',$id)->update(['is_verifaied' => 1]);
        return redirect('/home');
    }

    public function resend() {

        request()->user()->sendEmailVerificationNotification();

        return response()->json(['Message'=> 'Request has been sent!'],200);
    }
}