<?php

namespace Database\Seeders;

use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelImages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
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
      $res= Hotel::create($data);
      $image_data1=['img'=>'/default_photo/SweetPark/sweet1.jpg','restaurant_id'=>$res->id];
      $image_data2=['img'=>'/default_photo/SweetPark/sweet2.jpg','restaurant_id'=>$res->id];
      $image_data3=['img'=>'/default_photo/SweetPark/sweet3.jpg','restaurant_id'=>$res->id];
      $image_data4=['img'=>'/default_photo/SweetPark/sweet4.jpg','restaurant_id'=>$res->id];
      HotelImages::create($image_data1);    
      HotelImages::create($image_data2);    
      HotelImages::create($image_data3);    
      HotelImages::create($image_data4);    
}
}