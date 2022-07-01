<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
  
    protected function redirectTo($request)
    {
        
        if (! $request->expectsJson()) {
            // return response()->json('error from middelware');
            // return 'error from middelware';
            return route('not_logging');

        }
        return next($request);
        // dd();

    }
  
}
