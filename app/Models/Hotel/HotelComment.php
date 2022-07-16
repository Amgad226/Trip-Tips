<?php

namespace App\Models\Hotel;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelComment extends Model
{
    protected $table = 'hotel_comments';
    public $timestamps = false;


    protected $fillable = [
        'comment',
        'user_id',
        'hotel_id',
    ];

    public function  hotels()
    {
        return $this->belongsTo(Hotel::class,'hotel_id');
    }

    public function  user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
