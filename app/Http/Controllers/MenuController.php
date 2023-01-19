<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\MenuInterface;

class MenuController extends Controller
{
    private $menuInterface;
    public function __construct(MenuInterface $menuInterface)
    {
        $this->menuInterface = $menuInterface;
    }
    public function getAllItem(Request $request){
        return $this->menuInterface->getAllItem($request);
    }
}
