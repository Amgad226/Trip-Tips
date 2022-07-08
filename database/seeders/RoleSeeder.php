<?php

namespace Database\Seeders;

use App\Models\RoleApp;
use App\Models\RoleFacilities;
use App\Models\RolePerson;
use App\Models\RollApp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        RoleFacilities::create( ['role_name'=>'manager'         ,'id'=>1]);
        RoleFacilities::create( ['role_name'=>'supervisor'      ,'id'=>2]);

     

        RolePerson::create(['role_name'=>'user'       ,'id'=>1]);
        RolePerson::create(['role_name'=>'admin'      ,'id'=>2]);
        RolePerson::create(['role_name'=>'owner'      ,'id'=>3]);
    }
}
