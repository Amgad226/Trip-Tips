<?php

namespace App\Http\Controllers\Api\loging;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\welcomeMail;
use Laravel\Passport\Bridge\AuthCode;

class login extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request-> all(),[
            'name'       => ['required', 'string', 'max:50','min:3'],
            'email'      => 'required|email',//|unique:users
            'password'   => ['required', 'string', 'min:4'],
            'c_password' => 'required|same:password',
            'phone'      => 'required',
            'img'        => 'nullable',
        ]);
        if ($validator->fails())
        {
            return response()->json(['message'      => $validator->errors()],400);
        }
     
      
        if($request->hasFile('img'))
        { 
            $uniqid='('.uniqid().')';          //كل كرة بيعطيني رقم فريد     انا عم استخدمو مشان اسم كل صورة يكون غير التاني حتى لو اسم الصورة والمستخدم  نفسو

            $destination_path = 'public/images/users';    //storage بمسار الصورة للتخزين جوات ال  
            $request->file('img')->storeAs($destination_path,$uniqid.$request->img->getClientOriginalName());  //بل اسم واللاحقة الصح storage/public/images/users تخزينن الصورة بل
            //هلأ هون نحنا عاملين 
            //php artisan storage:link
            //الملفات الموجودة بل ستوريج بروح لحالها بصير بل بابليك ب هاد المسار
            $image_path = "/storage/images/users/" . $uniqid.$request->img->getClientOriginalName();           // مشان نبعتو بل ريسبونس للفلاتر publicباث الصورة يلي بل 
            //هيك الصورة فيك تفتحا ب رابط لوكال هوست متل ال بهب لانو صارت ب ملف البابليك وهيك بدا يوصللها لفلاتر 
         }
         else
         {
            $image_path='/user_default.png' ;
         }
         $input = [
            'name'      =>$request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'phone'     => $request->phone,
            'img'       => $image_path,   //هون حطيت باث الصورة يلي بل بابليك مشان يكون بل داتا بيز الباث يلي بينعرض  
      ];
        //encoding password before adding to databse
        $input['password'] = Hash::make($input['password']);

        //adding to database
        User::create($input);

        //عرفنا متحول وجبناه من جديد لليوزر مشان نحطو بل ريسبونس كامل
        //اما لو بدنا نبعتلو يلي فوق المعلومات يلي ما بدخلها بأيدو اليوزر ما رح تطلع متل الرول ايدي
        $user =User::where('email',$request->email)->first(); 
    
        //بعتنا ايميل  عن طريق ال ويلكوم ايميل يلي مأنشأينا نحن وعبيناها بمعلومات اليوزر 
        // Mail::to($user->email)->send(new welcomeMail($input));
        
        //create token 
        $token = $user->createToken('agmad')->accessToken;

        return response()->json([
        'message' => 'User successfully registered',
        'token' => $token,
        'user' => $user
        ], 200);
    }
    // _________________________________________________________________________________
    public function login(Request $request){ 
        if(Auth::attempt(['email' =>$request->email, 'password' => $request->password]))
           {
          
            $user =User::where('email',$request->email)->first(); 

        
            $token = $user->createToken('a')->accessToken;

            return response()->json([
               'message'=> 'User successfully login',
                'token'=>$token,
                'user' => $user
            ], 200);
        }

        else {
            return response()->json(['message' => 'Wrong email or password'], 400);
        }
    }
    // _________________________________________________________________________________
    public function logout(Request $request) 
    {        
      $request->user()->token()->revoke();
      return response()->json(['message' => 'User successfully logged out'],200);
    }
}
