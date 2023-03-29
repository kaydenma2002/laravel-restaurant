<?php

namespace App\Interfaces;

interface UserInterface
{
    public function authenticateUser($request);
    public function logout($request);
    
    public function getAllUsers();
    public function createUser($request);
    public function getProfile($request);
    public function getRecipient($request);
    public function updateUser($request);
    public function deleteUser($userId);
    public function confirmUser($request);
    public function getUserByEmail($request);
    public function resetPassword($request);
}