<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Airplane extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'airplane';

    protected $fillable = [
        'name_en',
     
    ];

    // public function bookingPackage() {
    //     return $this->hasOne(BookingPackage::class );
    // }
   
    public function bookingAirplane()
    {
        return $this->hasMany(BookingAirplane::class );
    }

}
