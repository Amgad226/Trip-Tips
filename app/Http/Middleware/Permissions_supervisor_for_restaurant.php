<?php

namespace App\Http\Middleware;

use App\Models\Restaurant\RestaurantRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permissions_supervisor_for_restaurant
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
      
        $user =User::with('RestaurantRole')->where('id',Auth::id())->first(); 
       

            foreach($user->RestaurantRole as $q)
            {
                // dd($request->restaurant->id);
                if (  $q->restaurant_id==$request->id  &&  $q->user_id==Auth::id())
                { 
                    return $next($request);
                }
            }
      
            return response()->json(['message'=>'انت مالك مانيجير او سوبر فايزور عهاد المطعم ','status'=>0],400);

        // }
        
    }
}
