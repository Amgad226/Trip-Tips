<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Facilitie extends Authenticatable
{
    protected $table = 'facilities';

    protected $fillable = [
        'facilities_name',
     
    ];

}
