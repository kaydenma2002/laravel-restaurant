<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\OwnerInterface;

class OwnerController extends Controller
{
    private $ownerInterface;
    public function __construct(OwnerInterface $ownerInterface)
    {
        $this->ownerInterface = $ownerInterface;
    }
    public function login(Request $request)
    {
        return $this->ownerInterface->login($request);
    }
    public function logout(Request $request)
    {
        return $this->ownerInterface->logout($request);
    }
    public function users(Request $request)
    {
        return $this->ownerInterface->users($request);
    }
    public function chats_and_contacts(Request $request)
    {
        return $this->ownerInterface->chats_and_contacts($request);
    }
    public function chats(Request $request)
    {
        return $this->ownerInterface->chats($request);
    }
    public function createChats(Request $request)
    {
        return $this->ownerInterface->createChats($request);
    }
    public function restaurants(Request $request)
    {
        return $this->ownerInterface->restaurants($request);
    }
    public function items(Request $request)
    {
        return $this->ownerInterface->items($request);
    }
    public function orders(Request $request)
    {
        return $this->ownerInterface->orders($request);
    }
    public function sales(Request $request)
    {
        return $this->ownerInterface->sales($request);
    }
    public function notifications()
    {
        return $this->ownerInterface->notifications();
    }
    public function updateIsReadByNotificationId(Request $request){
        return $this->ownerInterface->updateIsReadByNotificationId($request);
    }
    public function updateIsReadForAll(Request $request){
        return $this->ownerInterface->updateIsReadForAll($request);
    }
    public function deleteNotificationById(Request $request){
        return $this->ownerInterface->deleteNotificationById($request);
    }
    
    
    public function viewUserById(Request $request){
        return $this->ownerInterface->viewUserById($request);
    }
    public function viewItemById(Request $request){
        return $this->ownerInterface->viewItemById($request);
    }
    
    public function updateRestaurantById(Request $request){
        return $this->ownerInterface->updateRestaurantById($request);
    }
    public function viewRestaurantById(Request $request){
        return $this->ownerInterface->viewRestaurantById($request);
    }
    public function viewRestaurantsByUserId(Request $request){
        return $this->ownerInterface->viewRestaurantsByUserId($request);
    }
    public function viewItemsByOrderId(Request $request){
        return $this->ownerInterface->viewItemsByOrderId($request);
    }
    public function closeRestaurantById(Request $request){
        return $this->ownerInterface->closeRestaurantById($request);
    }
    public function approveClaimById(Request $request){
        return $this->ownerInterface->approveClaimById($request);
    }
    public function deleteUserById(Request $request)
    {
        return $this->ownerInterface->deleteUserById($request);
    }
    public function updateUserById(Request $request)
    {
        return $this->ownerInterface->updateUserById($request);
    }
    public function viewOrderById(Request $request)
    {
        return $this->ownerInterface->viewOrderById($request);
    }
    public function viewOrdersByRestaurantId(Request $request)
    {
        return $this->ownerInterface->viewOrdersByRestaurantId($request);
    }
    public function deleteOrderById(Request $request)
    {
        return $this->ownerInterface->deleteOrderById($request);
    }
    public function viewReservationById(Request $request)
    {
        return $this->ownerInterface->viewReservationById($request);
    }

    public function deleteReservationById(Request $request)
    {
        return $this->ownerInterface->deleteReservationById($request);
    }
    
    
    
}
