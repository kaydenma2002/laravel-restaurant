<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\CartInterface;
use App\Models\Cart;
use App\Models\User;
use App\Models\Restaurant;
use Exception;

class CartRepository implements CartInterface
{
    public function create($request)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('item_id', $request->item_id)
            ->first();

        if (!$cart) {
            return Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'restaurant_id' => $request->restaurant_id,
                'quantity' => $request->quantity
            ]);
        } else {
            return Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'restaurant_id' => $request->restaurant_id,
                'quantity' => $request->quantity
            ]);
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
    public function updateById($request)
    {

        if($request->type){
            
            if($request->type === 'increase'){
                $cart = Cart::Where('id',$request->id)->where('user_id',Auth::id())->first();
                if($cart){
                    $cart->quantity = $request->quantity;
                    $cart->save(); 
                    
                }
                
            }elseif($request->type === 'decrease'){
                $cart = Cart::Where('id',$request->id)->where('user_id',Auth::id())->first();
                if($cart){
                    $cart->quantity = $request->quantity;
                    return $cart->save(); 
                }
            }
        }
    }
    public function find($request)
    {   
        $restaurant = Restaurant::where('web_id',$request->web_id)->first();
        if($restaurant !=null){
            $cart = Cart::with('user', 'item')->where('user_id', Auth::id())->where('restaurant_id',$restaurant->restaurant_id)->get();
            if($cart->sum('quantity') > 0){
                return $cart;
            }else{
                return ['message' => 'empty cart','type' => 0];
            }
            
        }else{
            return ['message' => 'restaurant not exist','type' => 1]; ;
        }
    }
}
