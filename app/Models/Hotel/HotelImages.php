<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HotelImages extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'hotels_images';
    public $timestamps = false;


    protected $fillable = [
   'img','hotel_id'
    ];
    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id');
    }
 
}
