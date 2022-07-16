<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryHotel;
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
        CategoryHotel::create( ['name'=>'بحر'   ]);
        CategoryHotel::create( ['name'=>'جبل'       ]);
        CategoryHotel::create( ['name'=>'طبيعة'    ]);
        CategoryHotel::create( ['name'=>'جبل'    ]);
        CategoryHotel::create( ['name'=>'اثار'    ]);
        CategoryHotel::create( ['name'=>'تاريخي'    ]);
        CategoryHotel::create( ['name'=>'مدينة'    ]);
        CategoryHotel::create( ['name'=>'ريف'    ]);
      
    }
}
