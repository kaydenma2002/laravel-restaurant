<?php

namespace App\Interfaces;

interface AdminInterface
{
    public function login($request);
    public function logout($request);
    public function users($request);
    public function restaurants($request);
    public function claims($request);
    public function viewUserById($request);
    public function viewClaimByID($request);
    public function viewRestaurantById($request);
    public function updateRestaurantById($request);

    public function viewRestaurantsByUserId($request);
    public function closeRestaurantById($request);
    public function updateUserById($request);
    public function deleteUserById($request);
    public function viewOrderById($request);
    public function viewOrdersByRestaurantId($request);
    public function deleteOrderById($request);
    public function viewReservationById($request);
    public function approveClaimById($request);
    public function deleteReservationById($request);
}
