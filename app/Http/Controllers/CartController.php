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
    public function remove(){
        return $this->CartInterface->remove();
    }

    public function find(){
        return $this->CartInterface->find();
    }

}
