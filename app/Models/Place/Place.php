<?php

namespace App\Models\Place;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{  use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'places';

    protected $fillable = [
        'name_en',
        'name_ar',
        'location',
        'img',
        'category_id',
    ];

    public function  packages()
    {
        return $this->hasMany(Package::class,'place_id');
    }

    public function categories(){
        return $this->belongsTo(Category::class);
    }
}
