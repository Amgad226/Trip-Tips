<?php

namespace App\Models\Package;


use App\Models\Place\Place;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PackagePlace extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'package_places';
    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'place_id',
        'place_booking',
        'place_name',

    ];

    public function palce()
    {
        return $this->belongsTo(Place::class,'place_id' );
    }



    public function package()
    {
        return $this->belongsTo(Package::class,'package_id' );
    }
}