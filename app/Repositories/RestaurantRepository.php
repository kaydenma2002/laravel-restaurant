<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\RestaurantInterface;
use App\Models\Item;
use App\Models\Restaurant;

class RestaurantRepository implements RestaurantInterface
{
    public function index()
    {
        return Restaurant::paginate(10);
    }
    public function search($request){
        return Restaurant::where('name','LIKE', '%' . $request->search . '%')->orWhere('zip_code',$request->search)->orWhere('city',$request->search)->orWhere('state',$request->search)->orWhere('status',$request->search)->paginate(10);
    }
    public function create($request)
{
    try {
        // Find the existing restaurant
        $existedRestaurant = Restaurant::where('name', 'LIKE', $request->type . '%')->first();

        // Check if the restaurant exists
        if (!$existedRestaurant) {
            // Handle the case where the restaurant doesn't exist or provide an appropriate response
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        // Fetch menu items associated with the existing restaurant
        $items = Item::where('restaurant_id', $existedRestaurant->restaurant_id)->get();

        // Create a new restaurant entry (if not already created)
        $random_id = strval(rand(10000000000000,100000000000000));
        $restaurant = Restaurant::create([
            'restaurant_id' => $random_id,
        'name' => $request->restaurant_name,
        'address' => $request->location,
        'zip_code' => $request->zip_code,
        'web_id' => str_replace(' ', '', $request->restaurant_name) . '-' . $request->zip_code,
        ]);
        
        
        
        $empty_array = [];
        foreach ($items as $item) {
            $newItem = new Item();
            $newItem->title = $item->title;
            $newItem->price = $item->price;
            $newItem->description = $item->description;
            
            $newItem->note = $item->note;
            $newItem->category = $item->category;
            $newItem->restaurant_id = $random_id;
            $newItem->save();
        }
        

        return response()->json(['data' => $restaurant ], 200);
    } catch (\Exception $e) {
        // Handle the exception or return an error response
        return response()->json(['message' => $items], 500);
    }
}

    public function getRestaurantById($request){
        return Restaurant::where('restaurant_id',$request->restaurant_id)->first();
    }
    public function getRestaurantByWebId($request){
        return Restaurant::where('web_id',$request->web_id)->latest('created_at')->first();
    }
}