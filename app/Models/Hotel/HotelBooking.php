<?php

namespace App\Models\Hotel;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HotelBooking extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'hotel_booking';

    protected $fillable = [
        'hotel_id',
        'user_id',
    ];
}