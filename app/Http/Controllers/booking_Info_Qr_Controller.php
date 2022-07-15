<?php

namespace App\Http\Controllers;

use App\Models\Airplane\AirplaneBooking;
use App\Models\Hotel\HotelBooking;
use App\Models\Restaurant\RestaurantBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class booking_Info_Qr_Controller extends Controller
{
    public function show($id,$bookingid)
    {
        echo $id;
        if(request()->a=='res')
        {
         $booking = RestaurantBooking::where('id',$bookingid)->where('user_id',$id)->first(); 
        }

        if(request()->a=='hot')
        {
         $booking = HotelBooking::where('id',$bookingid)->where('user_id',$id)->first(); 
        }
        if(request()->a=='air')
        {
         $booking = AirplaneBooking::where('id',$bookingid)->where('user_id',$id)->first(); 
        }
     
        $user = User::where('id',$id)->first(); 
        // return;
        // dd($item);
        // dd($user->first_name);
        return view('bookingInfo',['user'=>$user,'booking'=>$booking]);
  

    }
    
}