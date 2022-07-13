<?php

namespace App\Models\Package;

use App\Models\Airplane\Airplane;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelClass;
use App\Models\Hotel\HotelImages;
use App\Models\Restaurant\Restaurant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use \Znck\Eloquent\Traits\BelongsToThrough;
use \Znck\Eloquent\Traits\BelongsToThrough;

class PackageHotel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'package_hotels';
    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'hotel_id',
        'class_hotel_id',
        'hotel_booking_end_date',
        'hotel_booking_start_date',
       
    ];


    

    
 /*___________________________________________________________________________________________________________________________________*/
 
    public function hotel()
    {
        return $this->belongsTo(Hotel::class,'hotel_id' );
    }

    public function class()
    {
        return $this->belongsTo(HotelClass::class,'class_hotel_id' );
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id' );
    }


    
}