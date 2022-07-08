<?php

namespace App\Models\Hotel;

use App\Models\Hotel\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HotelRole extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'hotel_role';

    protected $fillable = [
        'user_id',
        'hotel_id',
        'role_facilities_id',
     
        
    ];
    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id');
    }

    public function user(){
        return $this->belongsTo(User ::class,'user_id');
    }

}
