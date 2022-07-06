<?php

namespace App\Models\Airplane;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneImage extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'images_airplane';

    protected $fillable = [
   'img','airplane_id'
    ];

 
}
