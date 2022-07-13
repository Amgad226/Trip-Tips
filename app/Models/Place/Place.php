<?php

namespace App\Models\Place;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{  use  HasFactory;
    protected $table = 'places';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'location',
        'Payment',
        'support_email',
        'img_title_deed',
        'description',
        'acceptable',
        'user_id',
    ];

    public function  image()
    {
        return $this->hasMany(PlaceImage::class);
    }

    // public function categories(){
    //     return $this->belongsTo(Category::class);
    // }
}
