<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\MenuInterface;

use App\Models\Restaurant;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Exception;

class MenuRepository implements MenuInterface
{
    public function getAllItem($request)
    {

        $restaurant = Restaurant::where('web_id', $request->web_id)->first();
        if($restaurant!=null){
            $item = Item::with('restaurant')->where('restaurant_id', $restaurant->restaurant_id)->get();
            $category = Item::with('restaurant')->where('restaurant_id', $restaurant->restaurant_id)->pluck('category')->unique();
            $category = $category->toArray();
            $returnObject = new \stdClass();
            $returnObject->item = $item;
            $returnObject->category = $category;
            
            return $returnObject;
        }else{
            return ;
        }
        
    }
    public function getAllItemByrestaurant($request)
    {
        $restaurant = Restaurant::with('user')->where('name', 'LIKE', '%' . strtolower($request->restaurant) . '%')->first();
        if ($restaurant) {

            try {
                $item = Item::where('restaurant_id', $restaurant->restaurant_id)->get();
                return ['item' => $item];
            } catch (Exception $e) {
                return new JsonResponse(['message' => $e->getMessage()]);
            }
        } else {
            return new JsonResponse(['success' => false]);
        }
    }
}
