<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\OrderInterface;
class OrderController extends Controller
{
    private $orderInterface;
    public function __construct(OrderInterface $orderInterface)
    {
        $this->orderInterface = $orderInterface;
    }
    public function create(Request $request){
        return $this->orderInterface->create($request);
    }
    public function createOrderItem(Request $request){
        return $this->orderInterface->createOrderItem($request);
    }
    public function getOrder(){
        return $this->orderInterface->getOrder();
    }
    public function getOrderById(Request $request){
        return $this->orderInterface->getOrderById($request);
    }
    public function getOrderItem(Request $request){
        return $this->orderInterface->getOrderItem($request);
    }
    public function getAllOrders(){
        return $this->orderInterface->getAllOrders();
    }
}
