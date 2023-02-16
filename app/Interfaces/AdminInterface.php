<?php

namespace App\Interfaces;

interface AdminInterface
{
    public function login($request);
    public function logout($request);
    public function dashboard();
}
