<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\AdminInterface;
use App\Models\Cart;
use App\Models\User;
use App\Models\Restaurant;

class AdminRepository implements AdminInterface
{
    public function login($request)
    {
        $user = User::where('email', $request->email)->where('user_type', '1')->first();

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
    public function dashboard()
    {
        $admin = User::where('user_type', '1')->get();
        $restaurants = Restaurant::where('status', 'Pending')->get();
        $customer = User::where('user_type', 0)->get();
        return response([
            'admin' => $admin,
            'restaurants' => $restaurants,
            'customers' => $customer,
        ]);
    }
}
