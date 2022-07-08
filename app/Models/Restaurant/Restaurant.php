<?php

namespace App\Models\Restaurant;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';


    protected $fillable = [
        'name',
        'rate',
        'location',
        'Payment',
        'support_email',
        'catigory_id',
        'img_title_deed',
        'img',
        'user_id',
        'acceptable'

    ];
    public function catigorys(){
        return $this->belongsTo(Category::class);
    }

    public function restaurant_comments(){
        return $this->hasMany(Restaurant_comment::class,'restaurant_id');
    }

    public function images(){
        return $this->hasMany(RestaurantImage::class);
    }
    public function restaurant_favorites(){
        return $this->hasMany(Restaurant_favorite::class,'restaurant_id');
    }

    public function packages(){
        return $this->hasOne(Package::class,'restaurant_id');
    }

    public function booking_restaurants(){
        return $this->hasMany(BookingRestaurant::class,'restaurant_id');
    }
}
