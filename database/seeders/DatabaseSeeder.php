<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Restaurant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::factory()->count(10)->create();
        Restaurant::factory()->count(10)->create();
        Menu::factory()->count(3)->has(Item::factory()->count(3))
        ->create();
        Item::factory()->count(10)->create();
        
    }
}
