<?php

namespace App\Models\Place;

use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceImage extends Model
{  
    use  HasFactory;

    protected $table = 'places_img';
    public $timestamps = false;

    protected $fillable = [
        'img',
        'place_id',
        

    ];

    public function  place()
    {
        return $this->belongsTo(Place::class,'places_id');
    }
}