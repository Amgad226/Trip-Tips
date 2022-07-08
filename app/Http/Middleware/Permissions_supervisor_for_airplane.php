<?php

namespace App\Http\Middleware;

use App\Models\Restaurant\RestaurantRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permissions_supervisor_for_airplane
{
   
    public function handle(Request $request, Closure $next)
    {
      
        $user =User::with('RestaurantRole','HotelRole','AirplaneRole','AppRole')->where('id',Auth::id())->first(); 
       
            foreach($user->AirplaneRole as $q)
            {
                if (  $q->airplane_id==$request->id  &&  $q->user_id==Auth::id() )
                { 
                    return $next($request);
                }
            }
      
            return response()->json(['message'=>'انت مالك مانيجير او سوبر فايزور  عهل شركة الطيران  ','status'=>0],400);

        
    }
}
