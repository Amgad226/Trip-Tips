<?php

namespace App\Models\Place;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceComment extends Model
{
    protected $table = 'place_comments';
    public $timestamps = false;

    protected $fillable = [
        'comment',
        'user_id',
        'place_id',
    ];

    public function  packages()
    {
        return $this->belongsTo(Package::class,'package_id');
    }

    public function  user()
    {
        return $this->belongsTo(User::class,'place_id');
    }
}
