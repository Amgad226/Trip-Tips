<?php

namespace App\Models\Hotel;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HotelClass extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   

    protected $table = 'hotel_classes';
    public $timestamps = false;

    protected $fillable = [
        'hotel_id',
     'class_name',
     'money'
    ];
    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id');
    }
  




}
