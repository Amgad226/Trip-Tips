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
            return response()->json(['error'      => $validator->errors()],400);
        }
     
        if($request->img==null)
        {
            $input = 
            [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password,
                'phone'     => $request->phone,
            ];
        }
        //encoding password before adding to databse
        $input['password'] = Hash::make($input['password']);

        //adding to database
        User::create($input);

        //عرفنا متحول وجبناه من جديد لليوزر مشان نحطو بل ريسبونس كامل
        //اما لو بدنا نبعتلو يلي فوق المعلومات يلي ما بدخلها بأيدو اليوزر ما رح تطلع متل الرول ايدي
        $user =User::where('email',$request->email)->first(); 

        //بعتنا ايميل  عن طريق ال ويلكوم ايميل يلي مأنشأينا نحن وعبيناها بمعلومات اليوزر 
        Mail::to($user->email)->send(new welcomeMail($input));
        
        //create token 
        $token = $user->createToken('agmad')->accessToken;

        return response()->json([
        'Message' => 'User successfully registered',
        'token' => $token,
        'user' => $user
        ], 201);
    }
    // _________________________________________________________________________________
    public function login(Request $request){ 
        if(Auth::attempt(['email' =>$request->email, 'password' => $request->password]))
           {
            //اخدنا اليوزر عن طريق المعلومات يلي طابقناها بل  شرط
            $user = Auth::user();

        
            $token = $user->createToken('a')->accessToken;

            return response()->json([
               'Message'=> 'User successfully login',
                'token'=>$token,
                'user' => $user
            ], 201);
        }

        else {
            return response()->json(['Message' => 'Wrong email or password'], 401);
        }
    }
    // _________________________________________________________________________________
    public function logout(Request $request) 
    {
      $request->user()->token()->revoke();
      return response()->json(['Message' => 'User successfully logged out']);
    }
}
