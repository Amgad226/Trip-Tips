<?php

namespace App\Models\Restaurant;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RestaurantBooking extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'restaurant_booking';
    public $timestamps = false;

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'number_of_people',
        'price',
        'booking_date',
        'note',
        'by_packge',
        'unique',

    ];
    public function restuarant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
}
