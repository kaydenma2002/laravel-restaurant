<?php

namespace App\Interfaces;

interface AdminInterface
{
    public function login($request);
    public function logout($request);
    public function dashboard();
    public function viewUserById($request);
    public function updateUserById($request);
    public function deleteUserById($request);
    public function viewOrderById($request);
    public function deleteOrderById($request);
    public function viewReservationById($request);
    public function deleteReservationById($request);
}
