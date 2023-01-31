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
            'card_number' => $request->card_number,
            'card_holder' => $request->card_holder,
            'exp_month' => $request->exp_month,
            'exp_year' => $request->exp_year,
            'cvv' => $request->cvv,
            'total' => $request->total,
            'email' => $request->email
        ]);
    }
}
