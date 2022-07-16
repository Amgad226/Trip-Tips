<?php

namespace App\Models\Airplane;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneComment extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'airplane_comments';
    public $timestamps = false;

    protected $fillable = [
        'comment',
        'user_id',
        'airplane_id',
    ];

    public function  airplanes()
    {
        return $this->belongsTo(Airplane::class,'airplane_id');
    }

    public function  users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
