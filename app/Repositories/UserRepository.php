<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use App\Interfaces\UserInterface;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Events\UserCreated;
use Illuminate\Console\Scheduling\Event;

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
    public function getAllUsers()
    {
        return User::with('restaurant')->where('id','!=',Auth::id())->get();
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
            'status' => $request->status
        ]);
        event(new UserCreated($user));
        return $user;
    }
    public function updateUser($request)
    {
        $user = Auth::user();
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
        return $request->user();
    }
    public function getRecipient($request){
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
            return redirect('http://localhost:5173/login');
        } else {
            return redirect('http://localhost:5173/login');
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
        }else{
            return response([
               'message' => 'Invalid reset code'
            ], 400);
        }
    }
}
