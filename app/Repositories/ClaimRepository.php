<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\ClaimInterface;
use App\Models\Claim;
use App\Models\Notification;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use App\Events\ClaimCreated;
use App\Events\NotificationCreated;

class ClaimRepository implements ClaimInterface
{
    public function create($request){
        if($request->web_id){
            $restaurant = Restaurant::where('web_id',$request->web_id)->first();
            if($restaurant){
                $claim =  Claim::create([
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'name' => $request->name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'sale_tax' => $request->sale_tax,
                    'meal_tax' => $request->meal_tax,
                    'business_property_return' => $request->business_property_return,
                    'bill_of_sale' => $request->bill_of_sale,
                    's_corp' => $request->s_corp,
                    'resale' => $request->resale,
                    'business_license' => $request->business_license,
                    'ss4' => $request->ss4,
                    'restaurant_id' => $restaurant->restaurant_id,
                    'user_id' => authUser()->id
                ]);
                $notification = Notification::create([
                    'user_id' => authUser()->id,
                    'type' => 0,
                    'title' =>'Claim',
                    'body' => 'Claim received for' . $restaurant->name . 'by' . authUser()->name,
                    'data' => $claim->id,
                    'add_data' => $restaurant->restaurant_id
                ]);
                event(new NotificationCreated($notification));
                event(new ClaimCreated(Claim::with('restaurant')->find($claim->id)));

                return $claim;
            }else{
                return response()->json(['error' => 'Restaurant not found.'], 500);
            }
            
        }else{
            return response()->json(['error' => 'Request not regconized'], 500);
        }
            
    }
}