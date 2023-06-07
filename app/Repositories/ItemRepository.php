<?php

namespace App\Repositories;


use App\Interfaces\ItemInterface;
use App\Models\Item;
use App\Models\Restaurant;
class ItemRepository implements ItemInterface
{
    public function getItemById($request){
        $restaurant = Restaurant::where('web_id',$request->web_id)->first();
        return Item::with('restaurant')->where('restaurant_id',$restaurant->restaurant_id)->where('id',$request->id)->first();
    }


}