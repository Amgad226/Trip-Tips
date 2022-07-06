<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFavorite extends Model
{
    protected $table = 'hotel_favorites';

    protected $fillable =[
        'date_hotel_fav',
        'user_id',
        'hotel_id',
    ];

    public function  hotels()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function  users()
    {
        return $this->belongsTo(User::class);
    }
}
