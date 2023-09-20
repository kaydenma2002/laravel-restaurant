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
    public function create(Request $request){
        return $this->restaurantInterface->create($request);
    }
    public function getRestaurantById(Request $request){
        return $this->restaurantInterface->getRestaurantById($request);
    }
    public function getRestaurantByWebId(Request $request){
        return $this->restaurantInterface->getRestaurantByWebId($request);
    }
    public function search(Request $request){
        return $this->restaurantInterface->search($request);
    }
}
