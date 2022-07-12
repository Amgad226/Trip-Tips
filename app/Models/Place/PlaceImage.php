<?php

namespace App\Models\Place;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceImage extends Model
{  use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'places_img';
    public $timestamps = false;

    protected $fillable = [
    ];
}