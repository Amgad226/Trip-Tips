<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package\CategoryPackage;
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
        CategoryPackage::create( ['name'=>'Romance'   ]);
        CategoryPackage::create( ['name'=>'Family'       ]);
        CategoryPackage::create( ['name'=>'Holidays'    ]);
        CategoryPackage::create( ['name'=>'Party'    ]);
        CategoryPackage::create( ['name'=>'أمجدالوتاركينغ'    ]);

      
    }
}
