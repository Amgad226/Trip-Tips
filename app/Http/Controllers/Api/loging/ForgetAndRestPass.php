<?php

namespace App\Http\Controllers\Api\loging;

use App\Http\Controllers\Controller;
use App\Mail\ResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetAndRestPass extends Controller
{
  public function forgot(){

  
    //   dd();
        $email=Auth::user()->email;
        if($email==null)
        return response()->json(['mes'=>'user not exist',404  ]);

        $token = Str::random(10);

        $details=[
            'title'=>'mail',
            'body'=>$token
        ];

        Mail::to($email)->send(new ResetMail ($details));
        try 
            {
                DB::table('users')->where('email',$email)->update(['password_token' => $token]);

                // DB::table('users')->insert(['password_token'=>$token]);
                return response()->json(['Message'=>'check your email']);
            }  

        catch(\Exception $e) 
            {
                // dd();
                return response()->json(['Message'=>$e->getMessage()]);
            } }
//_____________________________________________________________________________________/
  public function   reset(Request $re){
        // dd('dsa');
        $token = $re->input('token');
        $email=Auth::user()->email;

        $user = DB::table('users')->where('email',$email)->first();

        if( $user  ==null)
        {
            return response()->json(['message '=>'user dosent exist',404]);
        }
        
        if($user->password_token!=$token)
        {
            return response()->json(["mas"=>'invalide token',403]);
        }
        DB::table('users')->where('email',$email)->update(['password' => $re->input('password')]);

        // $user->password=($re->input('password'));
        // $user->save();
        DB::table('users')->where('email',$email)->update(['password_token' => null]);

        return response()->json(['mes'=>'success']);}}


