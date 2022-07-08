<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PackageImages extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'package_images';

    protected $fillable = [

    ];

 
}
