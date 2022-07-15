<?php

namespace Database\Seeders;

use App\Models\AppRollUser;
use App\Models\RoleApp;
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
            'role_person_id'=>3,
            'have_facilities'=>0,
            'is_registered'=>true,
            'is_verifaied'=>true,
            'time'=>'2021-1-1',


      ];
      $ayham = [
        'name'      =>'ayham',
        'email'     => 'ayham@gmail.com',
        'password'  => $password,
        'phone'     => '294564',
        'img'       => '/default_photo/ayham.jpg' ,
         'role_person_id'=>2,
         'have_facilities'=>0,
         'is_registered'=>true,
         'is_verifaied'=>true,
         'time'=>'2021-1-1',


  ];

  $aseel = [
    'name'      =>'Aseel',
    'email'     => 'aseel@gmail.com',
    'password'  => $password,
    'phone'     => '58546546',
    'img'       => '/default_photo/aseel.jpg' ,
    'role_person_id'=>2,
    'have_facilities'=>0,
    'is_registered'=>true,
    'is_verifaied'=>true,
    'time'=>date('Y-m-d'),


];

$yassmin = [
    'name'      =>'yassmin',
    'email'     => 'yassmin@gmail.com',
    'password'  => $password,
    'phone'     => '985681',
    'img'       => '/default_photo/yassmin.jpg' ,
    'role_person_id'=>2,
    'have_facilities'=>0,
    'is_registered'=>true,
    'is_verifaied'=>true,
    'time'=>'2021-1-1',

];
$user = [
    'name'      =>'user',
    'email'     => 'user@gmail.com',
    'password'  => $password,
    'phone'     => '985681',
    'img'       => '/default_photo/user_default.png' ,
    'role_person_id'=>1,
    'have_facilities'=>0,
    'is_registered'=>true,
    'is_verifaied'=>true,
    'time'=>'2021-1-1',

];
$omar = [
    'name'      =>'omar',
    'email'     => 'omar@gmail.com',
    'password'  => $password,
    'phone'     => '985681',
    'img'       => '/default_photo/user_default.png' ,
    'role_person_id'=>1,
    'have_facilities'=>0,
    'is_registered'=>true,
    'is_verifaied'=>true,
    'time'=>date('Y-m-d'),

];
        //encoding password before adding to databse

        //adding to database
      $a = User::create($amgad);
      $name=$a->roles->role_name;
      $a->role_peson_name=$name;
      $a->save();

      $a=      User::create($ayham);
      $name=$a->roles->role_name;
      $a->role_peson_name=$name;
      $a->save();

       $a= User::create($aseel);
       $name=$a->roles->role_name;
       $a->role_peson_name=$name;
       $a->save();
      $a=  User::create($yassmin);
      $name=$a->roles->role_name;
      $a->role_peson_name=$name;
      $a->save();
      $a=  User::create($user);
      $name=$a->roles->role_name;
      $a->role_peson_name=$name;
      $a->save();
       $a= User::create($omar);
       $name=$a->roles->role_name;
       $a->role_peson_name=$name;
       $a->save();


    }
}
