<?php

namespace App\Models\Package;

use App\Models\Airplane\Airplane;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelClass;
use App\Models\Hotel\HotelImages;
use App\Models\Restaurant\Restaurant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use \Znck\Eloquent\Traits\BelongsToThrough;
use \Znck\Eloquent\Traits\BelongsToThrough;

class PackageRestaurant extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'package_restaurants';

    protected $fillable = [
        'package_id',
        'restaurant_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id' );
    }



    public function package()
    {
        return $this->belongsTo(Package::class,'package_id' );
    }
}