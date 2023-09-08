<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomBroadcastAuthController extends Controller
{
    public function authenticate(Request $request)
    {

        // Implement your custom authorization logic here...
        return authUser();

        
    }
}
