<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AppRollUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $table = 'user_role_app';

    protected $fillable = [
        'user_id',
        'roles_app_id',
     
        
    ];

    public function user(){
        return $this->belongsTo(User ::class,'user_id');
    }

}
