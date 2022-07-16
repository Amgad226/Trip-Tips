<?php

namespace App\Models\Package;

use App\Models\Hotel\Hotel;
use App\Models\Package\Package;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPackage extends Model
{
    protected $table = 'catigories_package';

    public $timestamps = false;

    protected $fillable = [
        'name',

    ];
 

    

    public function package(){
        return $this->hasMany(Package::class);
    }

}
