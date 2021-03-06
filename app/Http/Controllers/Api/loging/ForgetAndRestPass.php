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
  public function forgot(Request $request){

        //جبنا اليوزر يلي بل ريكويست
        $user=User::where('email',$request->email)->first();
        //ازا مو موجود بل داتا بيز رجعلي رسالة فشل 
        if($user==null)
        return response()->json([
        'message'=>'user not exist',
        'status'=>0
        ],400);

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
                DB::table('users')->where('id',$user->id)->update(['password_token' => $token]);

                // DB::table('users')->insert(['password_token'=>$token]);
                return response()->json([
                    'message'=>'check your email',
                    'status'=>1
                ],200);
            }  

        catch(\Exception $e) 
            {
                //يفضل نستخدم تراي وكاتش  وقت نستعمل ال 
                //DB:table 
                return response()->json(['message'=>$e->getMessage(),'status'=>0],400);
            } }
//_____________________________________________________________________________________/
  public function  reset(Request $request){

        //اخدنا المعلومات من الريكويست وخزناهن
        $token = $request->token;
        $email=$request->email;
        $password= Hash::make($request->password);

        //طابقنا الايميل يلي مبعوت مع اليوزرات يلي عنا ازا مافي هيك يوزر ف باي 
        $user = DB::table('users')->where('email',$email)->first();
// dd($user);
        if( $user  ==null)
        {
            return response()->json(['message '=>'user dosent exist', 'status'=>0],400);
        }
        //ازا كان الرمز يلي كاتبلليي ياه بل ريكويست غير يلي مخزن بل داتا بيز برضو باي 
        if($user->password_token!=$token)
        {
            return response()->json(["message"=>'invalide token','status'=>0],400);
        }
        //ازا الشرطين ما تحققو
        //وقتا عدلي كلمة السر بل كلمة الجديدة يلي باعتلي ياها
        DB::table('users')->where('email',$email)->update(['password' =>$password]);

        //وساويلي الباسورد توكين نال مشان ما يضل يستخدم هاد الرمز ويغير كلمة السر كل شوي 
        DB::table('users')->where('email',$email)->update(['password_token' => null]);

        return response()->json(['message'=>'success','status'=>1],200);
    }


        
        public function  checkToken(Request $request){

            //اخدنا المعلومات من الريكويست وخزناهن
            $token = $request->token;
            $email=$request->email;
    
            //طابقنا الايميل يلي مبعوت مع اليوزرات يلي عنا ازا مافي هيك يوزر ف باي 
            $user = DB::table('users')->where('email',$email)->first();
            
            if( $user  ==null)
            {
                return response()->json(['message '=>'user dosent exist','status'=>0],400);
            }
            //ازا كان الرمز يلي كاتبلليي ياه بل ريكويست غير يلي مخزن بل داتا بيز برضو باي 
            if($user->password_token!=$token)
            {
                return response()->json(["message"=>'invalide token','status'=>0],400);
            }
           
            return response()->json(['message'=>'success','status'=>1],200);
        }
        }
    