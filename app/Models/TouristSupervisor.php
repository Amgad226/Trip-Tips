<?php

namespace App\Models;

use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristSupervisor  extends Model
{
    protected $table = 'tourist_supervisors';

    protected $fillable = [
        'name',
        'phone',
        'location',
    ];
    public $timestamps = false;

    // public function  booking_your_choices()
    // {
    //     return $this->hasOne(Booking_your_choice::class,'tourist_supervisor_id');
    // }
    public function  packages()
    {
        return $this->hasMany(Package::class);
    }
}
