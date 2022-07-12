<?php

namespace App\Models\Airplane;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AirplaneFavorite extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'airplane_favorites';
    public $timestamps = false;

    protected $fillable = [
        'date_airplane_fav',
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
    use HasFactory;
}
