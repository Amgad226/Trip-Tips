<?php

namespace App\Models\Airplane;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneComment extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'airplane_comments';

    protected $fillable = [
        'comment',
        'date_airplane',
        'user_id',
        'airplane_id',
    ];

    public function  airplanes()
    {
        return $this->belongsTo(Airplane::class);
    }

    public function  users()
    {
        return $this->belongsTo(User::class);
    }
}
