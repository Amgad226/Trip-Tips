<?php

namespace App\Models\Package;

use App\Models\Airplane\Airplane;
use App\Models\Package\CategoryPackage;

use App\Models\TouristSupervisor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use \Znck\Eloquent\Traits\BelongsToThrough;
use \Znck\Eloquent\Traits\BelongsToThrough;

class Package extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'packages';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'hotel_id',
        'airplane_id',
        'restaurant_id',
        'img',
        'description',
        'max_reservation',
        'number_of_reservation',
        'price',
        'discount_percentage',
        'tourist_supervisor_id',
        'start_date',
        'number_of_day',
        'end_date',
        'tourist_supervisor_id',
        'added_by',//
        'category_id',
    ];

    public function PackageAirplane() {
        return $this->hasMany(PackageAirplane::class );
    }

    public function PackageRestaurant() {
        return $this->hasMany(PackageRestaurant::class );
    }

    public function PackageHotel() {
        return $this->hasMany(PackageHotel::class );
    }
    public function PackagePlace() {
        return $this->hasMany(PackagePlace::class );
    }

    public function BookingPackage() {
        return $this->hasMany(PackageBooking::class );
    }

    public function category(){
        return $this->belongsTo(CategoryPackage::class,'category_id');
    }
    public function tourisSupervisor()
    {
        return $this->belongsTo(TouristSupervisor::class,'tourist_supervisor_id' );
    }
    public function packageComments(){
        return $this->hasMany(PackageComment::class);
    }
 /*___________________________________________________________________________________________________________________________________*/
    public function airplane()
    {
        return $this->hasMany(Airplane::class );
    }
  
    // public function hotel()
    // {
    //     return $this->belongsTo(Hotel::class,'hotel_id' );
    // }
   
}