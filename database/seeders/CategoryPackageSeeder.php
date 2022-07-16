<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryPackage;
use App\Models\CategoryRestaurant;
use App\Models\Facilitie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryPackage::create( ['name'=>'رومنسي'   ]);
        CategoryPackage::create( ['name'=>'عائلية'       ]);
        CategoryPackage::create( ['name'=>'العيد'    ]);
        CategoryPackage::create( ['name'=>'بارتي'    ]);
        CategoryPackage::create( ['name'=>'أمجدالوتاركينغ'    ]);
        CategoryPackage::create( ['name'=>'دونت_نو'    ]);

      
    }
}
