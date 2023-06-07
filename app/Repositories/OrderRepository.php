<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\OrderItem;

class OrderRepository implements OrderInterface
{
    public function create($request)
    {
        $restaurant = Restaurant::where('web_id',$request->restaurant_id)->first();
        return Order::create([

            'total' => $request->total / 100,
            'note' => $request->note,
            'restaurant_id' => $restaurant->restaurant_id,
            'user_id' => Auth::id()
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
    public function getOrder($request)
    {
        if($request->web_id == null){
            return Order::with('user','restaurant')->where('user_id',Auth::id())->get();
        }else{
            $restaurant = Restaurant::where('web_id',$request->web_id)->first();
            return Order::with('user','restaurant')->where('restaurant_id',$restaurant->restaurant_id)->get();
        }
        
    }
    public function getOrderById($request)
    {
        $restaurant = Restaurant::where('web_id',$request->web_id)->first();
        return Order::with('user')->where('id',$request->id)->first();
    }
    public function getOrderItem($request)
    {
        return OrderItem::with('order')->with('item')->where('order_id', $request->id)->get();
    }
    public function getAllOrders()
    {

        $orders = Order::with('user')->get();
        return $orders;
    }
}
