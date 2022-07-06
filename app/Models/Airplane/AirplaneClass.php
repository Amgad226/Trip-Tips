<?php

namespace App\Models\Airplane;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneClass extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'classes_in_airplane';

    protected $fillable = [
     
    ];



}
