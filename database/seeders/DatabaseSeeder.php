<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        User::factory()
            ->count(100)
            ->has(Restaurant::factory()->has(Menu::factory()->has(Item::factory()->count(50))))
            ->create();

        
        

    }
}
