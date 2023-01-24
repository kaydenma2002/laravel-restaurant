<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\MenuInterface;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Item;
class MenuRepository implements MenuInterface
{
    public function getAllItem($request)
    {
        $restaurant = Restaurant::with('user')->where('user_id',Auth::id())->first();
        $menu = Menu::with('restaurant')->where('restaurant_id',$restaurant->id)->first();
        $item = Item::with('menu')->where('menu_id',$menu->id)->get();
        return ['restaurant'=>$restaurant,'menu'=>$menu,'item'=>$item];
    }
}