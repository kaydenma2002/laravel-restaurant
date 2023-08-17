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
    public function chats_and_contacts(Request $request)
    {
        return $this->adminInterface->chats_and_contacts($request);
    }
    public function chats(Request $request)
    {
        return $this->adminInterface->chats($request);
    }
    public function createChats(Request $request)
    {
        return $this->adminInterface->createChats($request);
    }
    public function restaurants(Request $request)
    {
        return $this->adminInterface->restaurants($request);
    }
    public function claims(Request $request)
    {
        return $this->adminInterface->claims($request);
    }
    public function orders(Request $request)
    {
        return $this->adminInterface->orders($request);
    }
    public function sales(Request $request)
    {
        return $this->adminInterface->sales($request);
    }
    public function notifications()
    {
        return $this->adminInterface->notifications();
    }
    public function updateIsReadByNotificationId(Request $request){
        return $this->adminInterface->updateIsReadByNotificationId($request);
    }
    public function updateIsReadForAll(Request $request){
        return $this->adminInterface->updateIsReadForAll($request);
    }
    public function deleteNotificationById(Request $request){
        return $this->adminInterface->deleteNotificationById($request);
    }
    
    
    public function viewUserById(Request $request){
        return $this->adminInterface->viewUserById($request);
    }
    public function viewClaimById(Request $request){
        return $this->adminInterface->viewClaimById($request);
    }
    public function updateRestaurantById(Request $request){
        return $this->adminInterface->updateRestaurantById($request);
    }
    public function viewRestaurantById(Request $request){
        return $this->adminInterface->viewRestaurantById($request);
    }
    public function viewRestaurantsByUserId(Request $request){
        return $this->adminInterface->viewRestaurantsByUserId($request);
    }
    public function viewItemsByOrderId(Request $request){
        return $this->adminInterface->viewItemsByOrderId($request);
    }
    public function closeRestaurantById(Request $request){
        return $this->adminInterface->closeRestaurantById($request);
    }
    public function approveClaimById(Request $request){
        return $this->adminInterface->approveClaimById($request);
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
    public function viewOrdersByRestaurantId(Request $request)
    {
        return $this->adminInterface->viewOrdersByRestaurantId($request);
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
