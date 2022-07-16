<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        File::deleteDirectory(public_path('storage/images'));


        Storage::disk('local')->makeDirectory('public/images/package');
        Storage::disk('local')->makeDirectory('public/images/users');
        Storage::disk('local')->makeDirectory('public/images/place');

        // Storage::disk('local')->makeDirectory('public/images/restaurant/qr');
        // Storage::disk('local')->makeDirectory('public/images/hotel/qr');
        // Storage::disk('local')->makeDirectory('public/images/airplane/qr');
        // Storage::disk('local')->makeDirectory('public/images/package/qr');
        Storage::disk('local')->makeDirectory('public/default_photo/SweetPark/title_deed');
        Storage::disk('local')->makeDirectory('public/default_photo/Mac/title_deed');
        Storage::disk('local')->makeDirectory('public/default_photo/meredean/title_deed');
        Storage::disk('local')->makeDirectory('public/default_photo/hilton/title_deed');
        Storage::disk('local')->makeDirectory('public/default_photo/place');
        
        
        $this->call(TouristSupervisorSeeder::class);
        $this->call(CategoryRestaurantSeeder::class);
        $this->call(CategoryPackageSeeder::class);
        $this->call(CategoryHotelSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RestaurantSeeder::class);
        // $this->call(FacilitieSeeder::class);
        

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
