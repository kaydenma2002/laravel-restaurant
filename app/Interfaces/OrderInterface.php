<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function create($request);
    public function getAllOrders();
}