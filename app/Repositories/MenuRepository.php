<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\MenuInterface;
use App\Models\Menu;

class MenuRepository implements MenuInterface
{
    public function getAllItem($request)
    {
        $menu = Menu::with('items')->where('id',1)->first();
        return $menu;
    }
}