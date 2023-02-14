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
}
