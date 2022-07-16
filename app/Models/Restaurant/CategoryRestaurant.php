<?php

namespace App\Models\Restaurant;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Model;

class CategoryRestaurant extends Model
{
    protected $table = 'catigories_restaurant';

    public $timestamps = false;

    protected $fillable = [
        'name',

    ];
 

    public function restaurants(){
        return $this->hasMany(Restaurant::class);
    }


}
