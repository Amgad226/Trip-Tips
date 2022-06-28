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
            'email'      => 'required|email|unique:users',
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
     
        if($request->img==null){
            $input = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password,
                'phone'     => $request->phone,
            ];
        }

        $input['password'] = Hash::make($input['password']);
        // dd();
        $user = User::create($input);

        
        $success['token'] = $user->createToken('agmad')->accessToken;
        // dd($success['token']);
        // 
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
