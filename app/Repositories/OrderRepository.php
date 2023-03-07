<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use App\Interfaces\OrderInterface;
use App\Models\Order;

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
            'total' => $request->total,
            'email' => $request->email,
            'item_id' => json_encode($request->item_id)
        ]);
    }
    public function getAllOrders()
    {
        return Order::whereIn('item_id', [20201, 20201, 20201, 20201] )->get();
    }
}
