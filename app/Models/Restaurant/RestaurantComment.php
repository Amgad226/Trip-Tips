<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantComment extends Model
{

    protected $table = 'restaurant_comments';

    protected $fillable = [
        'comment',
        'date_restaurant',
        'user_id',
        'restaurant_id',
    ];

    public function  restaurants()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function  users()
    {
        return $this->belongsTo(User::class);
    }
}
