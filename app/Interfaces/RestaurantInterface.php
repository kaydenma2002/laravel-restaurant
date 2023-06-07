<?php

namespace App\Interfaces;

interface RestaurantInterface

{
    public function index();
    public function search($request);
    public function getRestaurantById($request);
    public function getRestaurantByWebId($request);
}