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

class   PackageAirplane extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'package_airplanes';
    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'airplane_id',
        'class_airplane_id',
    ];


    
  
    
    public function airplane()
    {
        return $this->belongsToMany(Airplane::class );
    }

    public function package()
    {
        return $this->belongsToMany(Package::class,'package_id' );
    }

  

}