<?php

namespace App\Models\Airplane;

use App\Models\RoleFacilities;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneRole extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;


    protected $table = 'airplane_role';

    protected $fillable = [
        'user_id',
        'airplane_id',
        'role_facilities_id',
        'airplane_name',
        'role_facilities_name',
        
     
        
    ];
    public function airplane(){
        return $this->belongsTo(Airplane::class,'airplane_id');
    }

    public function user(){
        return $this->belongsTo(User ::class,'user_id');
    }
    public function facilitie(){
        return $this->belongsTo(RoleFacilities::class,'role_facilities_id');
    }

}
