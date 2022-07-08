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
        echo "hi other";
    }
    
}