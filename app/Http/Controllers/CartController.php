<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CartInterface;
class CartController extends Controller
{
    private $CartInterface;
    public function __construct(CartInterface $cartRepository){
        $this->CartInterface = $cartRepository;
    }
    public function create(Request $request){
        return $this->CartInterface->create($request);
    }
    public function remove(Request $request){
        return $this->CartInterface->remove($request);
    }
    public function removeById(Request $request)
    {
        return $this->CartInterface->removeById($request);
    }

    public function find(){
        return $this->CartInterface->find();
    }

}
