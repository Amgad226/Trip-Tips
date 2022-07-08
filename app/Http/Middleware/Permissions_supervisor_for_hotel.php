<?php

namespace App\Http\Middleware;

use App\Models\Restaurant\RestaurantRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permissions_supervisor_for_hotel
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
      
        $user =User::with('HotelRole')->where('id',Auth::id())->first(); 
       
            foreach($user->HotelRole as $q)
            {
                // dd($request->restaurant->id);
                if (  $q->hotel_id==$request->id  &&  $q->user_id==Auth::id() )
                { 
                    return $next($request);
                }
            }
      
            return response()->json(['message'=>'انت مالك مانيجير او سوبر فايزور  عهاد الاوتيل ','status'=>0],400);

        // }
        
    }
}
