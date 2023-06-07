<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ItemInterface;

class ItemController extends Controller
{
    private $itemInterface;
    public function __construct(ItemInterface $itemInterface)
    {
        $this->itemInterface = $itemInterface;
    }
    public function getItemById(Request $request){
        return $this->itemInterface->getItemById($request);
    }
}
