<?php

namespace App\Http\Controllers;

use App\Models\Airplane\AirplaneBooking;
use App\Models\Hotel\HotelBooking;
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
                     return view('bookingInfo',['user'=>$user,'booking'=>$booking,'unique'=>$booking->unique]);
                    
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

        if(request()->a=='hot')
        {
         $booking = HotelBooking::where('id',$bookingid)->where('user_id',$id)->first(); 
         $type='hot';
        }
        if(request()->a=='air')
        {
         $booking = AirplaneBooking::where('id',$bookingid)->where('user_id',$id)->first(); 
         $type='air';

        }
     
        // return;
        // dd($item);
        // dd($user->first_name);
        // return view('bookingInfo',['user'=>$user,'booking'=>$booking]);
  

    }
    

    public function qr(Request $re){

        $id=7;//request->id
        $id_item=1;//request->name
        $a=User::where('id',$id)->first();
        $item=Item::where('id',$id_item)->first();
   
           $image = QrCode::format('png')
                    ->generate('http://127.0.0.1:8000/ss/'.$a->id.'.'.$a->unque.'.'.$item->id.'.'.$item->unquee);
         $output_file = '/img/qr-code/img-' . time() . '.png';
         Storage::disk('local')->put($output_file, $image);
         return  response()->json(
             ['msg'=>'QR CODE stored successfully']
           );
   }
   
}