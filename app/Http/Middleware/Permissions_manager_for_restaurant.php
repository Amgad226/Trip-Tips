<?php

namespace App\Http\Middleware;

use App\Models\Restaurant\RestaurantRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permissions_manager_for_restaurant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      
        $user =User::with('RestaurantRole','HotelRole','AirplaneRole','AppRole')->where('id',Auth::id())->first(); 
        //دخول ازا كان الاونر
         foreach($user->AppRole as $q)
         {
            if($q->user_id==Auth::id()&&$q->roles_app_id==1)
            {
                return $next($request);
            }
         }
       
            foreach($user->RestaurantRole as $q)
            {
                //دخول ازا كان المانيجر 
                if (  $q->restaurant_id==$request->id  &&  $q->user_id==Auth::id() && $q->role_facilities_id==1)
                { 
                    return $next($request);
                }
            }
      
            return response()->json(['message'=>'انت مالك مانيجير  عهاد المطعم ','status'=>0],400);

        // }
        
    }
}
