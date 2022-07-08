<?php

namespace Database\Seeders;

use App\Models\Airplane\Airplane;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelImages;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantImage;
use App\Models\Restaurant\RestaurantRole;
use App\Models\User;
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
        $user_id=2;
       $data=[
        'name'=>'SweetPark',
        'user_id'=>$user_id,
        'rate'=>5,
        'location'=>'altal',
        'Payment'=>config('global.Payment_retaurant'),
        'support_email'=>'ayham@gmail.com',
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg'
       ];
       User::where('id',$user_id)->update(['have_facilities'=>1]);
      $res= Restaurant::create($data);
      $restaurant_id=$res->id;
      $image_data1=['img'=>'/default_photo/SweetPark/sweet1.jpg','restaurant_id'=>$restaurant_id];
      $image_data2=['img'=>'/default_photo/SweetPark/sweet2.jpg','restaurant_id'=>$restaurant_id];
      $image_data3=['img'=>'/default_photo/SweetPark/sweet3.jpg','restaurant_id'=>$restaurant_id];
      $image_data4=['img'=>'/default_photo/SweetPark/sweet4.jpg','restaurant_id'=>$restaurant_id];
      RestaurantImage::create($image_data1);    
      RestaurantImage::create($image_data2);    
      RestaurantImage::create($image_data3);    
      RestaurantImage::create($image_data4);    
      RestaurantRole::create(['user_id'=>$user_id , 'restaurant_id'=>$restaurant_id,'role_facilities_id'=>1]);


      $user_id=1;
      $data=[
        'name'=>'Mac',
        'user_id'=>$user_id,
        'rate'=>5,
        'location'=>'USA',
        'Payment'=>config('global.Payment_retaurant'),
        'support_email'=>'Mac@gmail.com',
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg'
       ];
       User::where('id',$user_id)->update(['have_facilities'=>1]);
      $res= Restaurant::create($data);
      $restaurant_id=$res->id;
      $image_data1=['img'=>'/default_photo/Mac/1.jpg','restaurant_id'=>$restaurant_id];
      $image_data2=['img'=>'/default_photo/Mac/2.jpg','restaurant_id'=>$restaurant_id];
      $image_data3=['img'=>'/default_photo/Mac/3.jpg','restaurant_id'=>$restaurant_id];
      RestaurantImage::create($image_data1);    
      RestaurantImage::create($image_data2);    
      RestaurantImage::create($image_data3);    
      RestaurantRole::create(['user_id'=>$user_id , 'restaurant_id'=>$restaurant_id,'role_facilities_id'=>1]);


      $user_id=1;
      $data=[
        'name'=>'uncel osaca',
        'user_id'=>$user_id,
        'rate'=>5,
        'location'=>'jordan',
        'Payment'=>config('global.Payment_retaurant'),
        'support_email'=>'uncel@gmail.com',
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg'
       ];
       User::where('id',$user_id)->update(['have_facilities'=>1]);
      $res= Restaurant::create($data);
      $restaurant_id=$res->id;
      $image_data1=['img'=>'/default_photo/Uncel/uncel2.jpg','restaurant_id'=>$restaurant_id];
      $image_data2=['img'=>'/default_photo/Uncel/uncel.jpg' ,'restaurant_id'=>$restaurant_id];
      RestaurantImage::create($image_data1);    
      RestaurantImage::create($image_data2);    
      RestaurantRole::create(['user_id'=>$user_id , 'restaurant_id'=>$restaurant_id,'role_facilities_id'=>1]);

      


      // $data=[
      //   'name'=>'Hilton',
      //   'rate'=>5,
      //   'location'=>'syria',
      //   'Payment'=>config('global.Payment_hotel'),
      //   'support_email'=>'hilton@gmail.com',
      //   'img_title_deed'=>'/default_photo/hilton/title_deed/12.jpg'
      //  ];
      // $hotel= Hotel::create($data);

      // $image_data1=['img'=>'/default_photo/hilton/hilton.jpg' ,'hotel_id'=>$hotel->id];
      // $image_data2=['img'=>'/default_photo/hilton/hilton2.jpg','hotel_id'=>$hotel->id];
      // $image_data3=['img'=>'/default_photo/hilton/hilton3.jpg','hotel_id'=>$hotel->id];
      // $image_data4=['img'=>'/default_photo/hilton/hilton4.jpg','hotel_id'=>$hotel->id];
      // HotelImages::create($image_data1);    
      // HotelImages::create($image_data2);    
      // HotelImages::create($image_data3);    
      // HotelImages::create($image_data4); 

      // $data=[
      //   'name'=>'SyrianFlying',
      //   'location'=>'syria',
      //   'Payment'=>config('global.Payment_airplane'),
      //   'support_email'=>'salamo_3lekom@gmail.com',
      //   'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg'
      //  ];
      // $hotel= Airplane::create($data);

}
}