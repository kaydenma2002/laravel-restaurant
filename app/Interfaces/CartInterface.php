<?php

namespace App\Interfaces;

interface CartInterface
{
    public function create($request);
    public function find();
    public function remove();
    public function removeById($request);
}