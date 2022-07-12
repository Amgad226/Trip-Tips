<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageComment extends Model
{
    protected $table = 'comment_packages';
    public $timestamps = false;

    protected $fillable = [
        'comment',
        'date_package',
        'user_id',
        'package_id',
    ];

    public function  packages()
    {
        return $this->belongsTo(Package::class,'package_id');
    }

    public function  users()
    {
        return $this->belongsTo(User::class);
    }
}
