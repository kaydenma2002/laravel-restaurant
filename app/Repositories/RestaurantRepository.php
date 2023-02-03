<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\RestaurantInterface;

use App\Models\Restaurant;

class RestaurantRepository implements RestaurantInterface
{
    public function index()
    {
        return Restaurant::all();

    }
}