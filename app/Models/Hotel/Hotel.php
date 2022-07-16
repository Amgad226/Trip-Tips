<?php

namespace App\Models\Hotel;

use App\Models\Hotel\CategoryHotel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

    class Hotel extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
        public $timestamps = false;

    protected $table = 'hotels';

    protected $fillable = [
        'name',
        'rate',
        'location',
        'Payment',
        'support_email',
        'img_title_deed',
        'user_id',
        'acceptable',
        'description',
        'category_id',


    ];


    public function images(){
        return $this->hasMany(HotelImages::class);
    }
    public function classes(){
        return $this->hasMany(HotelClass::class);
    }
    public function category(){
        return $this->belongsTo(CategoryHotel::class,'category_id');
    }

    public function hotelComments(){
        return $this->hasMany(Hotelcomment::class,'hotel_id');
    }

    //------------------------------------------------------

  
   

    // public function hotel_favorites(){
    //     return $this->hasMany(Hotel_favorite::class,'hotel_id');
    // }

    // public function packages(){
    //     return $this->hasOne(Package::class,'hotel_id');
    // }

    // public function booking_hotels(){
    //     return $this->hasMany(HotelBooking::class,'hotel_id');
    // }
}
