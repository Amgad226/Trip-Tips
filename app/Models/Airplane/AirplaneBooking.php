<?php

namespace App\Models\Airplane;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneBooking extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'airpalne_booking';
    public $timestamps = false;

    protected $fillable = [
        'airplane_id',
        'user_id',
        'password',
    ];


    public function airplane() {
        return $this->belongsTo(Airplane::class );
    }
    
 /*___________________________________________________________________________________________________________________________________*/
    public function offer()
    {
        return $this->hasone(Offer::class );
    }
}        