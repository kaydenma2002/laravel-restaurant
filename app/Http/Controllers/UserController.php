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
    public function login(Request $request)
    {
        return $this->userInterface->authenticateUser($request);
    }
    public function logout(Request $request){
        return $this->userInterface->logout($request);
    }
    public function profile(Request $request){
        return $this->userInterface->getUserById($request);
    }
}
