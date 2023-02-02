<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\CartInterface;
use App\Models\Cart;
use App\Models\User;
class CartRepository implements CartInterface
{
    public function create($request){
        return Cart::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id
        ]);
    }
    public function find(){
        return Cart::with('user','item')->where('user_id',Auth::id())->get();
    }
}