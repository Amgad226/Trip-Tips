<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageFavorite extends Model
{
    protected $table = 'package_favorites';

    protected $fillable =[
        'date_pack_fav',
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
