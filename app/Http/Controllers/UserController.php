<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;

class UserController extends Controller
{
    private $userInterface;
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    public function register(Request $request)
    {
        return $this->userInterface->createUser($request);
    }
    public function login(Request $request)
    {
        return $this->userInterface->authenticateUser($request);
    }
    public function logout(Request $request)
    {
        return $this->userInterface->logout($request);
    }
    public function profile(Request $request)
    {
        return $this->userInterface->getProfile($request);
    }
    public function getRecipient(Request $request)
    {
        return $this->userInterface->getRecipient($request);
    }
    public function getAllUsers()
    {
        return $this->userInterface->getAllUsers();
    }
    public function update(Request $request) 
    {
        return $this->userInterface->updateUser($request);
    }
    public function confirm(Request $request)
    {
        return $this->userInterface->confirmUser($request);
    }
    public function getEmail(Request $request){
        return $this->userInterface->getUserByEmail($request);
    }
    public function resetPassword(Request $request){
        return $this->userInterface->resetPassword($request);
    }
}
