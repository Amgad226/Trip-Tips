<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
  
    protected function redirectTo($request)
    {
        
        if (! $request->expectsJson()) {
            return route('not_logging');
        }
        return next($request);
        // dd();

    }
    // public function handle($request, Closure $next, ...$guards)
    // {
    //     dd( Auth::id() );
    //     dd(Auth::check());
        

    //     if (Auth::check()) {
    //         return $next($request);
    //     }
    //     return Response()->json('mes=>go to login');
    // }
}
