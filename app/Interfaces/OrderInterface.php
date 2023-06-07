<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function create($request);
    public function createOrderItem($request);
    public function getOrder($request);
    public function getOrderById($request);
    public function getOrderItem($request);

    public function getAllOrders();
}