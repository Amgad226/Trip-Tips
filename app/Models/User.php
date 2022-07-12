<?php

namespace App\Models;

use App\Models\Airplane\AirplaneRole;
use App\Models\Hotel\HotelRole;
use App\Models\Restaurant\RestaurantRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'level',
        'img',
        'password_token',
        'is_verifaied',
        'role_person_id',
        'have_facilities',
        'wallet_id',
    ];



    public function RestaurantRole(){
        return $this->hasMany(RestaurantRole ::class);
    }
    public function HotelRole(){
        return $this->hasMany(HotelRole ::class);
    }
    public function AirplaneRole(){
        return $this->hasMany(AirplaneRole ::class);
    }

//-------------------------------------------------------------------------------------------------------
    public function roles()
    {
    return $this->belongsTo(RolePerson::class,'role_id');

    }
    // public function role() {
    //     return $this->belongsTo(Role::class );
    // }
    // --------------------------------------------------------
    public function wallets()
    {
        return $this->belongsTo(Wallet::class,'wallet_id');

    }
    public function Airpplane_comments(){
    return $this->hasMany(Airpplane_comment::class,'user_id');
}

    public function Airpplane_favorites(){
        return $this->hasMany(Airpplane_favorite::class,'user_id');
    }

    public function Favorite_packages(){
        return $this->hasMany(Favorite_package::class,'user_id');
    }

    public function Comment_packages(){
        return $this->hasMany(Comment_package::class,'user_id');
    }

    public function BookingAirplanes(){
        return $this->hasMany(BookingAirplane::class,'user_id');
    }

    public function Package_bookings(){
        return $this->hasMany(Package_booking::class,'user_id');
    }

    public function App_reviews(){
        return $this->hasMany(App_review::class,'user_id');
    }

    public function BookingHotels(){
        return $this->hasMany(BookingHotel::class,'user_id');
    }

    public function BookingRestaurants(){
        return $this->hasMany(BookingRestaurant::class,'user_id');
    }


    public function Hotel_comments(){
        return $this->hasMany(Hotel_comment::class,'user_id');
    }

    public function Hotel_favorites(){
        return $this->hasMany(Hotel_favorite::class,'user_id');
    }

    public function Restaurant_comments(){
        return $this->hasMany(Restaurant_comment::class,'user_id');
    }

    public function Restaurant_favorites(){
        return $this->hasMany(Restaurant_favorite::class,'user_id');
    }
}
