<?php

namespace App\Models\Restaurant;

use App\Models\Restaurant\CategoryRestaurant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    
    public $timestamps = false;


    protected $fillable = [
        'name',
        'rate',
        'location',
        'support_email',
        'category_id',
        'img_title_deed',
        'img',
        'user_id',
        'acceptable',
        'price_booking',
        'Payment',
        'description',

    ];
    public function category(){
        return $this->belongsTo(CategoryRestaurant::class,'category_id');
    }
   public function images(){
        return $this->hasMany(RestaurantImage::class);
    }

    public function restaurantComments(){
        return $this->hasMany(RestaurantComment::class);
    }
    //____________________________________
    

 
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
