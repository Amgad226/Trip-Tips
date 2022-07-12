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

class Package extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'packages';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'hotel_id',
        'airplane_id',
        'restaurant_id',
        'img',
        'description',
        'max_reservation',
        'number_of_reservation',
        'price',
        'discount_percentage',
        'tourist_supervisor_id',
        
        'added_by',//
    ];

    
    // public function PackageAirplane() {
    //     return $this->hasMany(PackageAirplane::class )->airplane;
    // }

    public function PackageAirplane() {
        return $this->hasMany(PackageAirplane::class );
    }

    public function PackageRestaurant() {
        return $this->hasMany(PackageRestaurant::class );
    }

    public function PackageHotel() {
        return $this->hasMany(PackageHotel::class );
    }

    public function BookingPackage() {
        return $this->hasMany(PackageBooking::class );
    }
    
 /*___________________________________________________________________________________________________________________________________*/
    public function airplane()
    {
        return $this->hasMany(Airplane::class );
    }
    // public function restaurant()
    // {
    //     return $this->belongsTo(Restaurant::class,'restaurant_id' );
    // }
    // public function hotel()
    // {
    //     return $this->belongsTo(Hotel::class,'hotel_id' );
    // }
    public function hotelImg()
    {
        return $this->hasManyThrough( HotelImages::class,Hotel::class);
    }
}