<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceComment extends Model
{
    protected $table = 'comment_place';
    public $timestamps = false;

    protected $fillable = [
        'comment',
        'user_id',
        'package_id',
    ];

    public function  packages()
    {
        return $this->belongsTo(Package::class,'package_id');
    }

    public function  users()
    {
        return $this->belongsTo(User::class,'package_id');
    }
}
