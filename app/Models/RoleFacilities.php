<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleFacilities extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'roles_facilities';

    protected $fillable = [
        'role_name',
   
    ];
}
