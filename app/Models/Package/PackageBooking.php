<?php

namespace App\Models\Package;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class   PackageBooking extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'package_booking';
    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'user_id',
        'number_of_people',
        'price',
        'start_date',
        'end_date',
        'unique',

        

    ];


    public function package() {
        return $this->belongsTo(Package::class ,'package_id');
    }

    public function user() {
        return $this->belongsTo(User::class ,'user_id');
    }
}