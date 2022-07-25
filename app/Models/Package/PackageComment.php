<?php

namespace App\Models\Package;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageComment extends Model
{
    protected $table = 'package_comments';
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

    public function  user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
