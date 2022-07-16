<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class TouristSupervisorFacilitie extends Authenticatable
{
    protected $table = 'facilities';
    public $timestamps = false;

    protected $fillable = [
        'facilities_name',
     
    ];

}
