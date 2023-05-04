<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function create($request);
    public function createOrderItem($request);
    public function getOrder();
    public function getOrderById($request);
    public function getOrderItem($request);

    public function getAllOrders();
}