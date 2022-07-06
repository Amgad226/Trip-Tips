<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HotelImages extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'images_hotel';

    protected $fillable = [
   'img','hotel_id'
    ];

 
}
