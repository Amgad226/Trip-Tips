<?php

namespace App\Http\Controllers\Api\loging;

use App\Http\Controllers\Controller;
use App\Mail\ResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetAndRestPass extends Controller
{
  public function forgot($request){

        //جبنا اليوزر يلي بل ريكويست
        $user=User::where('email',$request->eamil)->first();
        //ازا مو موجود بل داتا بيز رجعلي رسالة فشل 
        if($user==null)
        return response()->json(['Message'=>'user not exist',404  ]);

        //انشأنا رمز عشوائي من 10 حروف 
        $token = Str::random(10);

        $details=[
            'title'=>'mail',
            'body'=>$token
        ];
        //بعتنا عل ايميل تبع اليوزر هاد الرمز 
        Mail::to($user->email)->send(new ResetMail ($details));
        try 
            {   
                //هون حدثنا قيمو التوكين باسسورد بجدول اليوزر لقيمة التوكين يلي انشأناه
                DB::table('users')->where('email',$request->eamil)->update(['password_token' => $token]);

                // DB::table('users')->insert(['password_token'=>$token]);
                return response()->json(['Message'=>'check your email']);
            }  

        catch(\Exception $e) 
            {
                //يفضل نستخدم تراي وكاتش  وقت نستعمل ال 
                //DB:table 
                return response()->json(['Message'=>$e->getMessage()]);
            } }
//_____________________________________________________________________________________/
  public function  reset(Request $request){

        //اخدنا المعلومات من الريكويست وخزناهن
        $token = $request->token;
        $email=$request->eamil;
        $password= Hash::make($request->password);

        //طابقنا الايميل يلي مبعوت مع اليوزرات يلي عنا ازا مافي هيك يوزر ف باي 
        $user = DB::table('users')->where('email',$email)->first();

        if( $user  ==null)
        {
            return response()->json(['Message '=>'user dosent exist',404]);
        }
        //ازا كان الرمز يلي كاتبلليي ياه بل ريكويست غير يلي مخزن بل داتا بيز برضو باي 
        if($user->password_token!=$token)
        {
            return response()->json(["Message"=>'invalide token',403]);
        }
        //ازا الشرطين ما تحققو
        //وقتا عدلي كلمة السر بل كلمة الجديدة يلي باعتلي ياها
        DB::table('users')->where('email',$email)->update(['password' =>$password]);

        //وساويلي الباسورد توكين نال مشان ما يضل يستخدم هاد الرمز ويغير كلمة السر كل شوي 
        DB::table('users')->where('email',$email)->update(['password_token' => null]);

        return response()->json(['Message'=>'success']);}}


