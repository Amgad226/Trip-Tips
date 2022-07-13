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
    public $timestamps = false;

    protected $fillable = [
        'hotel_id',
        'user_id',
        'number_of_people',
        'number_of_room',
        'price',
        'stert_date',
        'end_date',
        'note',
        'by_packge',
        'hotel_class_id',


    ];
}