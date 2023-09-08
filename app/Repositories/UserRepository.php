<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Interfaces\UserInterface;
use App\Models\PhoneVerification;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Events\UserCreated;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Validation\ValidationException;

class UserRepository implements UserInterface
{

    /**
     * Function : Get All Users
     * @param NA
     * @return posts
     */
    public function authenticateUser($request)
    {

        $user = User::where('email', $request->email)->first();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $user;
        } 
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $response;
    }
    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'User log out successfully'
        ]);
    }
    public function getAllUsers()
    {
        return User::with('restaurants')->where('id', '!=', authUser()->id)->get();
    }


    /**
     * Function : Create User
     *
     * @param [type] $request
     * @return post
     */
    public function createUser($request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'status' => $request->status,
            'phone' => $request->phone,
            'street' => $request->street,
            'city' => $request->city,
            'zip_code' => $request->zip_code,

        ]);
        return $user;
    }
    public function updateUser($request)
    {
        $user = authUser();
        if (Hash::check($request->old_password, $user->password)) {
            if ($request->new_password != $request->confirm_password) {
                return response([
                    'message' => ['New password and confirm password must be the same']

                ], 201);
            } else {
                return User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);
            }
        } else {
            return response([
                'message' => 'Passwords do not match.'
            ], 201);
        }
    }

    /**
     * Function : Get User By Id
     * @param [type] $id
     * @return post
     */
    public function getProfile($request)
    {
        return authUser();
    }
    public function getRecipient($request)
    {
        return User::find($request->id);
    }

    /**
     * Function : Update User
     *
     * @param [type] $request
     * @param [type] $id
     * @return post
     */


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
    public function confirmUser($request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->status === '0') {
            $user->status = '1';
            $user->save();
            return redirect('https://localhost:3001/login');
        } else {
            return redirect('https://localhost:3001/login');
        }
    }
    public function getUserByEmail($request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            PasswordReset::create([
                'email' => $user->email,
                'token' => $request->verify_code,
            ]);
        }
        return $user;
    }
    public function resetPassword($request)
    {
        $reset = PasswordReset::where('email', $request->email)
            ->where('created_at', '>=', now()->subHours(24))
            ->latest()->first();
        if ($reset->token === $request->verify_code) {

            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();
            $reset->delete();
            return response([
                'message' => 'Your password has been reset',

            ], 200);;
        } else {
            return response([
                'message' => 'Invalid reset code'
            ], 400);
        }
    }
}
