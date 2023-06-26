<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\AdminInterface;
use App\Models\Cart;
use App\Models\Claim;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Reservation;

class AdminRepository implements AdminInterface
{
    public function login($request)
    {
        $user = User::where('email', $request->email)->where('user_type', 0)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        } elseif ($user->status === '0') {
            return response([
                'message' => ['Please verify your email address to activate your account.']

            ], 404);
        } elseif ($user->status === '2') {
            return response([
                'message' => ['This account has been blocked. Please contact our support staff.']


            ], 404);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'User log out successfully'
        ]);
    }
    public function users($request)
    {
        if ($request->status != 'null') {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return  User::where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->orderBy($request->key, $request->order)->paginate($request->paginate ?? 10);
            } else {
                return  User::where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->paginate($request->paginate ?? 10);
            }
        }else{
            if ($request->key !== 'null' && $request->order !== 'null') {
                return  User::where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->orderBy($request->key, $request->order)->paginate($request->paginate ?? 10);
            } else {
                return  User::where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->paginate($request->paginate ?? 10);
            }
        }
    }
    public function restaurants($request)
    {
        if ($request->status != 'null') {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Restaurant::with('user')->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->orderBy($request->key, $request->order)->paginate($request->paginate ?? 10);
            } else {
                return Restaurant::with('user')->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->paginate($request->paginate ?? 10);
            }
        } else {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Restaurant::with('user')->where('name', 'LIKE', '%' . $request->search . '%')->orderBy($request->key, $request->order)->paginate($request->paginate ?? 10);
            } else {
                return Restaurant::with('user')->where('name', 'LIKE', '%' . $request->search . '%')->paginate($request->paginate ?? 10);
            }
        }
    }
    public function claims($request){
        if ($request->status != 'null') {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Claim::with(['restaurant','user'])->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->orderBy($request->key, $request->order)->paginate($request->paginate ?? 10);
            } else {
                return Claim::with(['restaurant','user'])->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->paginate($request->paginate ?? 10);
            }
        } else {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Claim::with(['restaurant','user'])->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })->paginate($request->paginate ?? 10);
            } else {
                return Claim::with(['restaurant','user'])->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })->paginate($request->paginate ?? 10);
            }
        }
        
    }
    public function viewUserById($request)
    {
        $user = User::find($request->id); // Assuming there is a User model

        if ($user->restaurants->isEmpty()) {
            return $user;
        }

        return $user->restaurants;
    }
    public function viewRestaurantById($request){
        $restaurant = Restaurant::find($request->id); // Assuming there is a User model

        

        return $restaurant->user;
    }
    public function updateUserById($request)
    {
        $user = User::find($request->id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();
        $restaurant = Restaurant::where('user_id', $user->id)->first();
        $restaurant->name = $request->restaurant_name;
        $restaurant->address = $request->address;
        $restaurant->save();
        return response(['success' => true, 'message' => 'User updated successfully']);
    }
    public function deleteUserById($request)
    {
        $user = User::find($request->id);
        return $user->delete();
    }

    public function viewOrderById($request)
    {
        return OrderItem::with('item')->where('order_id', $request->id)->get();
    }
    public function deleteOrderById($request)
    {
        $order = Order::find($request->id);
        return $order->delete();
    }
    public function viewReservationById($request)
    {
        return Reservation::find($request->id);
    }
    public function deleteReservationById($request)
    {
        $reservation = Reservation::find($request->id);
        return $reservation->delete();
    }
}
