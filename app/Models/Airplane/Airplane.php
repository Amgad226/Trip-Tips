<?php

namespace App\Models\Airplane;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Airplane extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'airplanes';

    protected $fillable = [
        'name',
        'location',
        'Payment',
        'support_email',
        'img_title_deed',
        'user_id',
        'acceptable',

     
    ];

    // public function bookingPackage() {
    //     return $this->hasOne(BookingPackage::class );
    // }
   
    public function bookingAirplane()
    {
        return $this->hasMany(BookingAirplane::class );
    }

}
