<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Hotel\CategoryHotel;
use App\Models\Package\CategoryPackage;
use App\Models\Restaurant\CategoryRestaurant;
use App\Models\TouristSupervisor;


class CategoryController extends Controller
{

    public function getRestaurantCategory(){
      
        $category=CategoryRestaurant::all();
        return response()->json([
            'message'=>' done',
            'status'=>1,
            'category'=>$category],200);
    }

    public function getHotelCategory(){
      
        $category=CategoryHotel::all();
        return response()->json([
            'message'=>' done',
            'status'=>1,
            'category'=>$category],200);
    }
    public function getPackageCategory(){
      
        $category=CategoryPackage::all();
        return response()->json([
            'message'=>' done',
            'status'=>1,
            'category'=>$category],200);
    }
    public function getTouristSupervisor(){
      
        $TouristSupervisor=TouristSupervisor::all();
        // dd($TouristSupervisor);
        return response()->json([
            'message'=>' done',
            'status'=>1,
            'TouristSupervisor'=>$TouristSupervisor],200);
    }


}