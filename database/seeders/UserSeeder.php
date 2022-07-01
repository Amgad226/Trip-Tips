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
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    
   
    public function run()
    {
$password=Hash::make(123456);

        
        $amgad = [
            'name'      =>'amgad wattar',
            'email'     => 'amgad@gmail.com',
            'password'  => $password,
            'phone'     => '094562182',
            'img'       => '/default_photo/amgad.jpg' ,
            'role_id'=>4

      ];
      $ayham = [
        'name'      =>'ayham',
        'email'     => 'ayham@gmail.com',
        'password'  => $password,
        'phone'     => '294564',
        'img'       => '/default_photo/ayham.jpg' ,
         'role_id'=>3

  ];

  $aseel = [
    'name'      =>'Aseel',
    'email'     => 'aseel@gmail.com',
    'password'  => $password,
    'phone'     => '58546546',
    'img'       => '/default_photo/aseel.jpg' ,
    'role_id'=>2

];

$yassmin = [
    'name'      =>'yassmin',
    'email'     => 'aseel@gmail.com',
    'password'  => $password,
    'phone'     => '985681',
    'img'       => '/default_photo/yassmin.jpg' ,
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
