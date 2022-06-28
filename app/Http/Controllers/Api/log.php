<?php

namespace App\Http\Controllers\Api\auth;

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
class log extends Controller
{
    
    public function register(Request $request)
    {
        // dd($request->first_name);
        $validator = Validator::make($request-> all(),[
            'name' => ['required', 'string', 'max:50','min:3'],
            // 'last_name'  => ['required', 'string', 'max:50','min:3'],
            'email'      => 'required',
            'password'   => ['required', 'string', 'min:4'],
            'c_password' => 'required|same:password',
            'phone'      => 'required',
            'img'        => 'nullable',
        ]);
        if ($validator->fails()){

            return response()->json([
                'error'      => $validator->errors()],400
              );
        }
        
        // اذا مافي صورة بل ريكويست 
        //عبيلي قيم الريكويست ما عدا الصوة بل داتا 
        //ووقت ينبعتو البيانات عل داتابيز لحالها الصورة هنيك بتصير نال
        if($request->img==null){
            $input = [
                'first_name'=> $request->first_name,
                'last_name' => $request->last_name,
                'email'     => $request->email,
                'password'  => $request->password,
                'phone'     => $request->phone,
            ];
        }

        if($request->hasFile('img'))
        { 
            $uniqid='('.uniqid().')';                                 //كل كرة بيعطيني رقم فريد     انا عم استخدمو مشان اسم كل صورة يكون غير التاني حتى لو اسم الصورة والمستخدم  نفسو

            $destination_path = 'public/images/users';                       //storage بمسار الصورة للتخزين جوات ال  
            $request->file('img')->storeAs($destination_path,$uniqid.$request->img->getClientOriginalName());  //بل اسم واللاحقة الصح storage/public/images/users تخزينن الصورة بل
            //هلأ هون نحنا عاملين 
            //php artisan storage:link
            //The [C:\Users\ASUS\Desktop\New folder\X-Buyer old\public\storage] link has been connected to [C:\Users\ASUS\Desktop\New folder\X-Buyer old\storage\app/public].
            //الملفات الموجودة بل ستوريج بروح لحالها بصير بل بابليك ب هاد المسار
            $image_path = "/storage/images/users/" . $uniqid.$request->img->getClientOriginalName();           // مشان نبعتو بل ريسبونس للفلاتر publicباث الصورة يلي بل 
            //هيك الصورة فيك تفتحا ب رابط لوكال هوست متل ال بهب لانو صارت ب ملف البابليك وهيك بدا يوصللها لفلاتر 
            
            $input = [
                'first_name'=> $request->first_name,
                'last_name' => $request->last_name,
                'email'     => $request->email,
                'password'  => $request->password,
                'phone'     => $request->phone,
                'img'       => $image_path,   //هون حطيت باث الصورة يلي بل بابليك مشان يروح الباث عل داتا بيز واسيل تاخد هاد الباث 
          ];
         }
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        
        $success['token'] = $user->createToken('AyhamAseelAmgadNour')->accessToken;
        // event(new Registered($user));
        // $user->notify(new WelcomeEmailNotification());
        // Mail::to($user->email)->send(new ResetMail ($details));
        // dd($input['first_name']);
        // Mail::to($user->email)->send(new welcomeMail($input));ph

        return response()->json([
        'msg' => 'User successfully registered',
        'token' => $success,
        'user' => $user
        ], 201);
    }
    // _________________________________________________________________________________
    public function login(Request $request){ 
        if(Auth::attempt(['email' =>$request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            
            $success['token'] = $user->createToken('a')->accessToken;

            return response()->json([
               'msg'=> 'User successfully login',
                'token'=>$success,
                'user' => $user
            ], 201);
        }

        else if(Auth::attempt(['first_name' =>$request->first_name, 'password' => $request->password]))
        {
            $user = Auth::user();
            
            $success['token'] = $user->createToken('a')->accessToken;

            return response()->json([
               'msg'=> 'User successfully login',
                'token'=>$success,
                'user' => $user
            ], 201);
        }
        else {
            return response()->json(['error' => 'Wrong email or password'], 401);
        }
    }
    // _________________________________________________________________________________
    public function logout(Request $request) 
    {
      $request->user()->token()->revoke();
      return response()->json(['message' => 'User successfully logged out']);
    }
}
