<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingYourChoice extends Model
{
    protected $table = 'booking_your_choices';

    protected $fillable = [
        'img_qr',
        'tourist_supervisor_id',

    ];

    public function  tourist_supervisors()
    {
        return $this->belongsTo(Tourist_supervisor:: class);
    }
////
    public function booking_airplanes ()
    {

        return $this->belongsTo(BookingAirplane::class);
    }
    public function booking_restaurants ()
    {

        return $this->belongsTo(BookingRestaurant::class);
    }
}
