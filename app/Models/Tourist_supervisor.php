<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourist_supervisor extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'tourist_supervisors';

    protected $fillable = [
        'name',
    ];
    public $timestamps = false;

    public function  booking_your_choices()
    {
        return $this->hasOne(Booking_your_choice::class,'tourist_supervisor_id');
    }
    public function  packages()
    {
        return $this->hasOne(Package::class,'tourist_supervisor_id');
    }
}
