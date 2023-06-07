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
        return Restaurant::paginate(10);
    }
    public function search($request){
        return Restaurant::where('name','LIKE', '%' . $request->search . '%')->orWhere('zip_code',$request->search)->orWhere('city',$request->search)->orWhere('state',$request->search)->orWhere('status',$request->search)->paginate(10);
    }
    public function getRestaurantById($request){
        return Restaurant::where('restaurant_id',$request->restaurant_id)->first();
    }
    public function getRestaurantByWebId($request){
        return Restaurant::where('web_id',$request->web_id)->first();
    }
}