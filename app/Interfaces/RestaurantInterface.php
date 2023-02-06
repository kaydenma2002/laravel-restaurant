<?php

namespace App\Interfaces;

interface RestaurantInterface

{
    public function index();
    public function search($request);
}