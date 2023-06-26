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
    public function createCartBeforeLogin(Request $request){
        return $this->CartInterface->createCartBeforeLogin($request);
    }
    public function getCartBeforeLogin(Request $request){
        return $this->CartInterface->getCartBeforeLogin($request);
    }
    public function combineCart(Request $request){
        return $this->CartInterface->combineCart($request);
    }
    public function remove(Request $request){
        return $this->CartInterface->remove($request);
    }
    public function removeById(Request $request)
    {
        return $this->CartInterface->removeById($request);
    }
    public function UpdateById(Request $request)
    {
        return $this->CartInterface->UpdateById($request);
    }

    public function find(Request $request){
        return $this->CartInterface->find($request);
    }

}
