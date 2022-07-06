<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RestaurantClass extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'classes_in_resturant';

    protected $fillable = [
   'img','hotel_id'
    ];

 
}
