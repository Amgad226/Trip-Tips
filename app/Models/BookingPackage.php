<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BookingPackage extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'package_booking';

    protected $fillable = [
        'Package_id',
        'user_id',
    ];


    public function package() {
        return $this->belongsTo(Package::class ,'Package_id');
    }

    public function user() {
        return $this->belongsTo(User::class ,'user_id');
    }
}