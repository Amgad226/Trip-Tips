<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant\CategoryRestaurant;
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
        CategoryRestaurant::create( ['name'=>'Seafood'   ]);
        CategoryRestaurant::create( ['name'=>'Arabic'       ]);
        CategoryRestaurant::create( ['name'=>'Foreign '    ]);
        CategoryRestaurant::create( ['name'=>'Family '    ]);
        CategoryRestaurant::create( ['name'=>'Casino'    ]);
        CategoryRestaurant::create( ['name'=>'Benzema'    ]);

      
    }
}
