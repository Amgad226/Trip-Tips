<?php

namespace App\Models\Restaurant;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RestaurantRole extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'restaurant_role';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'role_facilities_id',
     
        
    ];
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

    public function user(){
        return $this->belongsTo(User ::class,'user_id');
    }

}
