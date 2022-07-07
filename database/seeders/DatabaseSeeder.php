<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('local')->makeDirectory('public/images/users');
        Storage::disk('local')->makeDirectory('public/default_photo/SweetPark');
        Storage::disk('local')->makeDirectory('public/default_photo/SweetPark/title_deed');
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FacilitieSeeder::class);
        $this->call(RestaurantSeeder::class);
        

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
