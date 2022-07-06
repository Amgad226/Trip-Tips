<?php

namespace Database\Seeders;

use App\Models\Facilitie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Facilitie::create( ['facilities_name'=>'restaurant'   ,'id'=>1]);
        Facilitie::create( ['facilities_name'=>'hotel'        ,'id'=>2]);
        Facilitie::create( ['facilities_name'=>'airplane'     ,'id'=>3]);
    }
}
