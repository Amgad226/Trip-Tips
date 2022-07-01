<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
// use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use Faker\Extension\Container;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    
   
    public function run()
    {
        
        $amgad = [
            'name'      =>'amgad wattar',
            'email'     => 'amgad@gmail.com',
            'password'  => '123456',
            'phone'     => '094562182',
            'img'       => '/user_default.png' ,
            'role_id'=>4

      ];
      $ayham = [
        'name'      =>'ayham',
        'email'     => 'ayham@gmail.com',
        'password'  => '123456',
        'phone'     => '294564',
        'img'       => '/user_default.png' ,
         'role_id'=>3

  ];

  $aseel = [
    'name'      =>'Aseel',
    'email'     => 'aseel@gmail.com',
    'password'  => '123456',
    'phone'     => '58546546',
    'img'       => '/user_default.png' ,
    'role_id'=>2

];
$yassmin = [
    'name'      =>'yassmin',
    'email'     => 'aseel@gmail.com',
    'password'  => '123456',
    'phone'     => '985681',
    'img'       => '/user_default.png' ,
    'role_id'=>1
];
        //encoding password before adding to databse

        //adding to database
        User::create($amgad);
        User::create($ayham);
        User::create($aseel);
        User::create($yassmin);
    }
}
