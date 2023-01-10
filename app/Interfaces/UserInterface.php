<?php

namespace App\Interfaces;

interface UserInterface
{
    public function authenticateUser($request);
    public function logout($request);
    
    public function getAllUsers();
    public function createUser($request);
    public function getUserById($request);
    public function updateUser($request, $userId);
    public function deleteUser($userId);
}