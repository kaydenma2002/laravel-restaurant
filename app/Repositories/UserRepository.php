<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{

    /**
     * Function : Get All Users
     * @param NA
     * @return posts
     */
    public function authenticateUser($request)
    {
        $user= User::where('email', $request->email)->first();
        
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }
    public function logout($request){
        $request->user()->currentAccessToken()->delete();
        return response([
            'message'=> ['User log out successfully'],200
        ]);
    }
    public function getAllUsers()
    {
        return User::with('restaurant')->get();
    }

    /**
     * Function : Create User
     *
     * @param [type] $request
     * @return post
     */
    public function createUser($request)
    {
        return User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Function : Get User By Id
     * @param [type] $id
     * @return post
     */
    public function getUserById($request)
    {
        return $request->user();
    }

    /**
     * Function : Update User
     *
     * @param [type] $request
     * @param [type] $id
     * @return post
     */
    public function updateUser($request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user['title'] = $request->title;
            $user['content'] = $request->content;
            $user->save();
            return $user;
        }
    }

    /**
     * Function : Delete User
     * @param [type] $id
     * @return void
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }
    }
}