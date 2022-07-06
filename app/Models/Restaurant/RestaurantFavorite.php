<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantFavorite extends Model
{
    protected $table = 'restaurant_favorites';

    protected $fillable =[
        'date_rest_fav',
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
