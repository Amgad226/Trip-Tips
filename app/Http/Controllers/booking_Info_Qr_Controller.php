<?php

namespace App\Http\Controllers;

use App\Models\Airplane\AirplaneBooking;
use App\Models\Hotel\HotelBooking;
use App\Models\Package\PackageBooking;
use App\Models\Restaurant\RestaurantBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class booking_Info_Qr_Controller extends Controller
{
    public function show($id,$token,$bookingid,$unique)
    {
        $user = User::where('id',$id)->first(); 

        // echo $id;
        if(request()->type=='res')
        {
            $booking = RestaurantBooking::where('user_id',$id)->where('unique',$unique)->where('user_id',$id)->first(); 
            
            if($booking!=null)
            {
               
                     $type='res';
                     return view('bookingInfo',['user'=>$user,'booking'=>$booking,'unique'=>$booking->unique,'type'=>$type]);
                    
            }
            else{
                echo $id;
                echo '<br>';
                echo $token;
                echo '<br>';
                echo $bookingid;
                echo '<br>';
                echo $unique;
            }
        }

        if(request()->type=='hot')
        {
            // dd();
            $booking = HotelBooking::where('user_id',$id)->where('unique',$unique)->where('user_id',$id)->first(); 
      
            if($booking!=null)
            {
               
                     $type='hot';
                     return view('bookingInfo',['user'=>$user,'booking'=>$booking,'unique'=>$booking->unique,'type'=>$type]);
                    
            }
            else{
                echo $id;
                echo '<br>';
                echo $token;
                echo '<br>';
                echo $bookingid;
                echo '<br>';
                echo $unique;
            }
        }
        
        if(request()->type=='air')
        {
         $booking = AirplaneBooking::where('id',$bookingid)->where('unique',$unique)->where('user_id',$id)->first(); 
      
         if($booking!=null)
         {
            
                  $type='air';
                  return view('bookingInfo',['user'=>$user,'booking'=>$booking,'unique'=>$booking->unique,'type'=>$type]);
                 
         }
         else{
             echo $id;
             echo '<br>';
             echo $token;
             echo '<br>';
             echo $bookingid;
             echo '<br>';
             echo $unique;
         }
        }
           
        if(request()->type=='pack')
        {
         $booking = PackageBooking::where('id',$bookingid)->where('unique',$unique)->where('user_id',$id)->first(); 
      
         if($booking!=null)
         {
            
                  $type='pack';
                  return view('bookingInfo',['user'=>$user,'booking'=>$booking,'unique'=>$booking->unique,'type'=>$type]);
                 
         }
         else{
             echo $id;
             echo '<br>';
             echo $token;
             echo '<br>';
             echo $bookingid;
             echo '<br>';
             echo $unique;
         }
        }
     
        // return;
        // dd($item);
        // dd($user->first_name);
        // return view('bookingInfo',['user'=>$user,'booking'=>$booking]);
  

    }
    

 
   
}