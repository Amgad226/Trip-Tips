<?php

namespace App\Http\Middleware;

use App\Models\Restaurant\RestaurantRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permissions_manager_for_airplane
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
      
        $user =User::with('AirplaneRole')->where('id',Auth::id())->first(); 
        
        
            foreach($user->AirplaneRole as $q)
            {
                // dd($request->restaurant->id);
                if (  $q->airplane_id==$request->id  &&  $q->user_id==Auth::id() && $q->role_facilities_id==1)
                { 
                    return $next($request);
                }
            }
      
            return response()->json(['message'=>'انت مالك مانيجير  عهل شركة الطيران ','status'=>0],400);

        // }
        
    }
}
