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
        $cart = Cart::where('user_id', Auth::id())
                    ->where('item_id', $request->item_id)
                    ->first();
        
        if(!$cart){
            return Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'quantity' => 1
            ]);
        }else{
            $cart->increment('quantity');
            return $cart;
        }
    }
    public function remove()
    {
        return Cart::where('user_id', Auth::id())->delete();
    }
    public function removebyId($request)
    {
        return Cart::where('id', $request->id)->delete();
    }
    public function find(){
        return Cart::with('user','item')->where('user_id',Auth::id())->get();
    }
}