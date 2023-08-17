<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use App\Events\NotificationCreated;
use App\Models\Notification;
class OrderRepository implements OrderInterface
{
    public function create($request)
    {
        $restaurant = Restaurant::where('web_id',$request->restaurant_id)->first();
        
        $order =  Order::create([

            'total' => $request->total / 100,
            'note' => $request->note,
            'restaurant_id' => $restaurant->restaurant_id,
            'user_id' => Auth::id()
        ]);
        $notification = Notification::create([
            'user_id' => Auth::id(),
            'type' => 0,
            'title' =>'Order',
            'body' => 'Order created at' . ''. $restaurant->name . ' by ' . Auth::user()->name,
            'data' => $order->id,
            'add_data' => $restaurant->restaurant_id
        ]);
        event(new NotificationCreated($notification));
        event(new OrderCreated(Order::with(['user','restaurant'])->find($order->id)));
        return $order;
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
