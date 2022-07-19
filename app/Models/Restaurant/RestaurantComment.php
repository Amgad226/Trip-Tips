<?php

namespace App\Models\Restaurant;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantComment extends Model
{
    public $timestamps = false;

    protected $table = 'restaurant_comments';

    protected $fillable = [
        'comment',
        'user_id',
        'restaurant_id',
    ];

    public function  restaurants()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

    public function  user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
