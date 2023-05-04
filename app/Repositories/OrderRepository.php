<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\Item;
use App\Models\OrderItem;
class OrderRepository implements OrderInterface
{
    public function create($request)
    {
        return Order::create([
            
            'total' => $request->total / 100,
            'note' => $request->note,
            
            'user_id'=> Auth::id()
        ]);
    }
    public function createOrderItem($request)
    {
        return OrderItem::create([
            'item_id' => $request->item_id,
            'order_id' => $request->order_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);
    }
    public function getOrder(){
        return Order::with('user')->where('user_id',Auth::id())->get();
    }
    public function getOrderById($request){
        return Order::find($request->id);
    }
    public function getOrderItem($request){
        return OrderItem::with('order')->with('item')->where('order_id',$request->id)->get();
    }
    public function getAllOrders()
    {

        $orders = Order::with('user')->get();
        return $orders;
    }
}
