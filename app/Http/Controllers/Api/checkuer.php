<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class checkuer extends Controller
{
    public function check(Request $request)
    {
        // echo "hi admin/owner";
        return response()->json(['message'=>'hi '.Auth::user()->name.'you are admin/owner'],200);
    }
    
    public function nameByToken(Request $request)
    {
        // echo "hi admin/owner";
        return response()->json(['message'=>'hi '.Auth::user()->name],200);
    }
    
}