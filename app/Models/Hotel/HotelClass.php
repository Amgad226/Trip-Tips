<?php

namespace App\Models\Hotel;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HotelClass extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'classes_in_hotel';

    protected $fillable = [
     
    ];



}
