<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\ClaimInterface;
use App\Models\Claim;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class ClaimRepository implements ClaimInterface
{
    public function create($request){
        if($request->web_id){
            $restaurant = Restaurant::where('web_id',$request->web_id)->first();
            if($restaurant){
                return Claim::create([
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'name' => $request->name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'ss4' => $request->ss4,
                    'food_license' => $request->food_license,
                    'restaurant_id' => $restaurant->restaurant_id,
                    'user_id' => Auth::id()
                ]);
            }else{
                return response()->json(['error' => 'Restaurant not found.'], 500);
            }
            
        }else{
            return response()->json(['error' => 'Request not regconized'], 500);
        }
            
    }
}