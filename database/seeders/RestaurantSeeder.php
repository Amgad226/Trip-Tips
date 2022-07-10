<?php

namespace Database\Seeders;

use App\Models\Airplane\Airplane;
use App\Models\Airplane\AirplaneClass;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelClass;
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
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg',
        'price_booking'=>12,
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
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg',
        'price_booking'=>12,

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
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg',
        'price_booking'=>12,

       ];
       User::where('id',$user_id)->update(['have_facilities'=>1]);
      $res= Restaurant::create($data);
      $restaurant_id=$res->id;
      $image_data1=['img'=>'/default_photo/Uncel/uncel2.jpg','restaurant_id'=>$restaurant_id];
      $image_data2=['img'=>'/default_photo/Uncel/uncel.jpg' ,'restaurant_id'=>$restaurant_id];
      RestaurantImage::create($image_data1);    
      RestaurantImage::create($image_data2);    
      RestaurantRole::create(['user_id'=>$user_id , 'restaurant_id'=>$restaurant_id,'role_facilities_id'=>1]);

      

      $user_id=3;
      $data=[
        'user_id'=>$user_id,
        'name'=>'Hilton',
        'rate'=>3,
        'location'=>'UAE',
        'Payment'=>config('global.Payment_hotel'),
        'support_email'=>'hilton@gmail.com',
        'img_title_deed'=>'/default_photo/hilton/title_deed/12.jpg'
       ];
      $hotel= Hotel::create($data);

      $image_data1=['img'=>'/default_photo/hilton/hilton.jpg' ,'hotel_id'=>$hotel->id];
      $image_data2=['img'=>'/default_photo/hilton/hilton2.jpg','hotel_id'=>$hotel->id];
      $image_data3=['img'=>'/default_photo/hilton/hilton3.jpg','hotel_id'=>$hotel->id];
      $image_data4=['img'=>'/default_photo/hilton/hilton4.jpg','hotel_id'=>$hotel->id];
      HotelImages::create($image_data1);    
      HotelImages::create($image_data2);    
      HotelImages::create($image_data3);    
      HotelImages::create($image_data4); 
      $class1=['hotel_id'=>$hotel->id,'money'=>1500,'class_name'=>'first'] ;
      $class2=['hotel_id'=>$hotel->id,'money'=>1200,'class_name'=>'second'] ;
      HotelClass::create($class1);
      HotelClass::create($class2);



      $user_id=1;
      $data=[
        'user_id'=>$user_id,
        'name'=>'meredean',
        'rate'=>5,
        'location'=>'UAE',
        'Payment'=>config('global.Payment_hotel'),
        'support_email'=>'meredean@gmail.com',
        'img_title_deed'=>'/default_photo/meredean/title_deed/12.jpg'
       ];
      $hotel= Hotel::create($data);

      $image_data1=['img'=>'/default_photo/meredean/meredean1.jpg','hotel_id'=>$hotel->id];
      $image_data2=['img'=>'/default_photo/meredean/meredean2.jpg','hotel_id'=>$hotel->id];
      $image_data3=['img'=>'/default_photo/meredean/meredean3.jpg','hotel_id'=>$hotel->id];
      $image_data4=['img'=>'/default_photo/meredean/meredean4.jpg','hotel_id'=>$hotel->id];
      HotelImages::create($image_data1);    
      HotelImages::create($image_data2);    
      HotelImages::create($image_data3);    
      HotelImages::create($image_data4); 
      $class1=['hotel_id'=>$hotel->id,'money'=>8999,'class_name'=>'Gold'] ;
      $class2=['hotel_id'=>$hotel->id,'money'=>7999,'class_name'=>'Selver'] ;
      $class2=['hotel_id'=>$hotel->id,'money'=>6999,'class_name'=>'Pronz'] ;
      HotelClass::create($class1);
      HotelClass::create($class2);






      $user_id=4;
      $data=[
        'user_id'=>$user_id,
        'name'=>'SyrianFlying',
        'location'=>'syria',
        'Payment'=>config('global.Payment_airplane'),
        'support_email'=>'salamo_3lekom@gmail.com',
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg'
       ];
      $airplane= Airplane::create($data);
      $class1=['airplane_id'=>$airplane->id,'money'=>200,'class_name'=>'first class'] ;
      $class2=['airplane_id'=>$airplane->id,'money'=>300,'class_name'=>'econime '] ;
      $class3=['airplane_id'=>$airplane->id,'money'=>400,'class_name'=>'golden'] ;
      AirplaneClass::create($class1);
      AirplaneClass::create($class2);
      AirplaneClass::create($class3);

      
      $user_id=3;
      $data=[
        'user_id'=>$user_id,
        'name'=>'salom',
        'location'=>'syria',
        'Payment'=>config('global.Payment_airplane'),
        'support_email'=>'salamo_3lekom@gmail.com',
        'img_title_deed'=>'/default_photo/SweetPark/title_deed/12.jpg'
       ];
      $airplane= Airplane::create($data);
      $class1=['airplane_id'=>$airplane->id,'money'=>300,'class_name'=>'poor'] ;
      $class2=['airplane_id'=>$airplane->id,'money'=>400,'class_name'=>'medium '] ;
      $class3=['airplane_id'=>$airplane->id,'money'=>600,'class_name'=>'rich'] ;
      AirplaneClass::create($class1);
      AirplaneClass::create($class2);
      AirplaneClass::create($class3);

}
}