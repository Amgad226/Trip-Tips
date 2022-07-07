<?php

namespace Database\Seeders;

use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data=[
        'name'=>'SweetPark',
        'rate'=>5,
        'location'=>'altal',
        'Payment'=>5000,
        'support_email'=>'ayham@gmail.com',
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg'
       ];
      $res= Restaurant::create($data);
      $image_data1=['img'=>'/default_photo/SweetPark/sweet1.jpg','restaurant_id'=>$res->id];
      $image_data2=['img'=>'/default_photo/SweetPark/sweet2.jpg','restaurant_id'=>$res->id];
      $image_data3=['img'=>'/default_photo/SweetPark/sweet3.jpg','restaurant_id'=>$res->id];
      $image_data4=['img'=>'/default_photo/SweetPark/sweet4.jpg','restaurant_id'=>$res->id];
      RestaurantImage::create($image_data1);    
      RestaurantImage::create($image_data2);    
      RestaurantImage::create($image_data3);    
      RestaurantImage::create($image_data4);    
}
}