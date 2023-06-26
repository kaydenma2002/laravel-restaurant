<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\AdminInterface;

class AdminController extends Controller
{
    private $adminInterface;
    public function __construct(AdminInterface $adminInterface)
    {
        $this->adminInterface = $adminInterface;
    }
    public function login(Request $request)
    {
        return $this->adminInterface->login($request);
    }
    public function logout(Request $request)
    {
        return $this->adminInterface->logout($request);
    }
    public function users(Request $request)
    {
        return $this->adminInterface->users($request);
    }
    public function restaurants(Request $request)
    {
        return $this->adminInterface->restaurants($request);
    }
    public function claims(Request $request)
    {
        return $this->adminInterface->claims($request);
    }
    public function viewUserById(Request $request){
        return $this->adminInterface->viewUserById($request);
    }
    public function viewRestaurantById(Request $request){
        return $this->adminInterface->viewRestaurantById($request);
    }
    
    public function deleteUserById(Request $request)
    {
        return $this->adminInterface->deleteUserById($request);
    }
    public function updateUserById(Request $request)
    {
        return $this->adminInterface->updateUserById($request);
    }
    public function viewOrderById(Request $request)
    {
        return $this->adminInterface->viewOrderById($request);
    }
    public function deleteOrderById(Request $request)
    {
        return $this->adminInterface->deleteOrderById($request);
    }
    public function viewReservationById(Request $request)
    {
        return $this->adminInterface->viewReservationById($request);
    }

    public function deleteReservationById(Request $request)
    {
        return $this->adminInterface->deleteReservationById($request);
    }
    
    
    
}
