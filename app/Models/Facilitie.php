<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Facilitie extends Authenticatable
{
    protected $table = 'facilities';
    public $timestamps = false;

    protected $fillable = [
        'facilities_name',
     
    ];

}
