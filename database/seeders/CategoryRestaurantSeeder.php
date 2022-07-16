<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryRestaurant;
use App\Models\Facilitie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryRestaurant::create( ['name'=>'بحري'   ]);
        CategoryRestaurant::create( ['name'=>'عربي'       ]);
        CategoryRestaurant::create( ['name'=>'اجنبي'    ]);
        CategoryRestaurant::create( ['name'=>'عائلي'    ]);
        CategoryRestaurant::create( ['name'=>'كازينو'    ]);
        CategoryRestaurant::create( ['name'=>'بينزيما'    ]);

      
    }
}
