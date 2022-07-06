<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{


    protected $fillable = [
        'name_en',
        'name_ar',


    ];
    public function catigorys(){
        return $this->belongsTo(Category::class);
    }

    public function restaurants(){
        return $this->hasMany(Restaurant::class,'category_id');
    }

    public function hotels(){
        return $this->hasMany(Hotels::class,'category_id');
    }

}
