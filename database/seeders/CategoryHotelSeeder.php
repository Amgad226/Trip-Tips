<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Hotel\CategoryHotel;
use App\Models\Facilitie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryHotel::create( ['name'=>'Sea'   ]);
        CategoryHotel::create( ['name'=>'mountain'       ]);
        CategoryHotel::create( ['name'=>'nature'    ]);
        CategoryHotel::create( ['name'=>'ruins'    ]);
        CategoryHotel::create( ['name'=>'Historical'    ]);
        CategoryHotel::create( ['name'=>'city'    ]);
        CategoryHotel::create( ['name'=>'countryside'    ]);
      
    }
}
