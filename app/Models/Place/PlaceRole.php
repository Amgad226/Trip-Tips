<?php

namespace App\Models\Place;

use App\Models\Place\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PlaceRole extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

// {{dd();}}

    protected $table = 'place_role';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'place_id',
        'role_facilities_id',
     
        
    ];
    public function place(){
        return $this->belongsTo(Place::class,'place_id');
    }

    public function user(){
        return $this->belongsTo(User ::class,'user_id');
    }

}
