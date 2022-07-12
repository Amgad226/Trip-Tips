<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelComment extends Model
{
    protected $table = 'restaurant_comments';
    public $timestamps = false;


    protected $fillable = [
        'comment',
        'date_hotel',
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
