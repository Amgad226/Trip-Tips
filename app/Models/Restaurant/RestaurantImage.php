<?php

namespace App\Models\Restaurant;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RestaurantImage extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'images_resturants';

    protected $fillable = [
        'img',
        'restaurant_id'
     
    ];
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }


}
