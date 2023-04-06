<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\DemoInterface;
use App\Models\Demo;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class DemoRepository implements DemoInterface
{
    public function create($request){
        $restaurant = Restaurant::where('restaurant_id', $request->restaurant_id)->first();
        $restaurant->user_id = Auth::id();
        $restaurant->status = 'Active';
        $restaurant->save();
        return Demo::create([
            'name' => $request->name,
            'company' => $request->company,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'email' => $request->email
        ]);
    }
}