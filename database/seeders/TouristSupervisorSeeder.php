<?php

namespace Database\Seeders;

use App\Models\Facilitie;
use App\Models\TouristSupervisor ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TouristSupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TouristSupervisor::create( ['name'=>'AMHAD' ,'phone'=>'0945623246','location'=>'syria'  ]);
        TouristSupervisor::create( ['name'=>'ALI'   ,'phone'=>'0945623246','location'=>'syria'    ]);
        TouristSupervisor::create( ['name'=>'OSAMA' ,'phone'=>'0945623246','location'=>'syria'   ]);
        TouristSupervisor::create( ['name'=>'ANDREH','phone'=>'0945623246','location'=>'syria'    ]);
        TouristSupervisor::create( ['name'=>'HADI'  ,'phone'=>'0945623246','location'=>'syria'  ]);
        TouristSupervisor::create( ['name'=>'ROZET' ,'phone'=>'0945623246','location'=>'syria'   ]);
        TouristSupervisor::create( ['name'=>'JWANA' ,'phone'=>'0945623246','location'=>'syria'   ]);
        TouristSupervisor::create( ['name'=>'TALA'  ,'phone'=>'0945623246','location'=>'syria'  ]);
    }
}
