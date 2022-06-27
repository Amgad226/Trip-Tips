<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Package extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'package';

    protected $fillable = [
        'name_en',
        'hotel_id',
        'airplane_id',
        'restaurant_id',
     
    ];


    
    public function BookingPackage() {
        return $this->hasMany(BookingPackage::class );
    }
    
 /*___________________________________________________________________________________________________________________________________*/
    public function airplane()
    {
        return $this->belongsTo(Airplane::class,'airplane_id' );
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id' );
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class,'hotel_id' );
    }
}