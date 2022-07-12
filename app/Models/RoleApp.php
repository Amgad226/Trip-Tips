<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleApp extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'roles_app';

    protected $fillable = [
        'role_name',
   
    ];
    public function user(){
        return $this->belongsTo(User ::class);
    }
}
