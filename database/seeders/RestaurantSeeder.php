<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            DB::table('restaurants')->insert([
                'name' => 'kayden restaurant',
                'address' => '7509 Davian Drive Annandale',
                'user_id' => 1,
            ]);
        
        
    }
}
