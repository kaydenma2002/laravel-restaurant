<?php

namespace App\Interfaces;

interface MenuInterface
{
    public function getAllItem($request);
    public function getAllItemByRestaurant($request);
}