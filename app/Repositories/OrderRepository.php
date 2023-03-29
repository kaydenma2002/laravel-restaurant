<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\Item;

class OrderRepository implements OrderInterface
{
    public function create($request)
    {
        return Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'street' => $request->street,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'company' => $request->company,
            'total' => $request->total / 100,
            'email' => $request->email,
            'item_id' => serialize($request->item_id),
            'user_id'=> Auth::id()
        ]);
    }
    public function getOrder(){
        return Order::where('user_id',Auth::id())->get();
    }
    public function getAllOrders()
    {

        $orders = Order::all();

        $items = Item::all();
        $items = $items->toArray();

        foreach ($orders as $order) {
            foreach ((unserialize($order->item_id)) as $index_id => $item_id) {
                foreach ($items as $item) {
                    if (in_array($item_id, $item)) {
                        $order[$index_id] = $item;
                    }
                }
            }
            $order->item_id = unserialize($order->item_id);
        }



        return $orders;
    }
}
