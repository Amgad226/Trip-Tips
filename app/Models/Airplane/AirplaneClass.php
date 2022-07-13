<?php

namespace App\Models\Airplane;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneClass extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'airplane_classes';

    protected $fillable = [
        'airplane_id',
        'class_name',
        'money',
    ];
    public function airplane(){
        return $this->belongsTo(Airplane::class,'airplane_id');
    }
}
