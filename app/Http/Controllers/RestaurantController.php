<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\RestaurantInterface;

class RestaurantController extends Controller
{
    private $restaurantInterface;
    public function __construct(RestaurantInterface $restaurantInterface)
    {
        $this->restaurantInterface  = $restaurantInterface;
    }
    public function index(){
        return $this->restaurantInterface->index();
    }
}
