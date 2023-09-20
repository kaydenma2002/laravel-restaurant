<?php

namespace App\Interfaces;

interface RestaurantInterface

{
    public function index();
    public function create($request);
    public function search($request);
    public function getRestaurantById($request);
    public function getRestaurantByWebId($request);
}