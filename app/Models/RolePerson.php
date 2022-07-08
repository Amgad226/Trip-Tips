<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePerson extends Model
{
    use HasFactory;

    protected $table = 'roles_person';

    protected $fillable = [
        'role_name',
   
    ];
}
