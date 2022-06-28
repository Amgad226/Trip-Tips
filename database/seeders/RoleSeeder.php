<?php

namespace Database\Seeders;

use App\Models\Role;
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
        Role::create( ['role_name'=>'user'         ,'id'=>1]);
        Role::create( ['role_name'=>'supervisor'   ,'id'=>2]);
        Role::create( ['role_name'=>'admin'        ,'id'=>3]);
        Role::create( ['role_name'=>'owner'        ,'id'=>4]);
    }
}
