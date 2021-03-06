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
        'airplane_class_id',
        'user_id',
        'from',
        'to',
        'date',
        'number_of_people',
        'price',
        'date',
        'note',
        'by_packge',
        'airplane_class_id',
        'unique',
    ];


    public function airplane() {
        return $this->belongsTo(Airplane::class );
    }

    
    public function airplaneClass(){
        return $this->belongsTo(AirplaneClass::class,'airplane_class_id');
    }
    
 /*___________________________________________________________________________________________________________________________________*/
  
}        