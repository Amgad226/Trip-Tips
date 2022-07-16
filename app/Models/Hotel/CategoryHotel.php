<?php

namespace App\Models\Hotel;
;

use App\Models\Hotel\Hotel;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryHotel extends Model
{
    protected $table = 'catigories_hotel';

    public $timestamps = false;

    protected $fillable = [
        'name',

    ];
 

    

    public function hotels(){
        return $this->hasMany(Hotel::class);
    }

}
