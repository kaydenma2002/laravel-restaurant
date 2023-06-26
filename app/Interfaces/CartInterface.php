<?php

namespace App\Interfaces;

interface CartInterface
{
    public function create($request);
    public function createCartBeforeLogin($request);
    public function getCartBeforeLogin($request);
    public function combineCart($request);
    public function find($request);
    public function remove();
    public function removeById($request);
    public function updateById($request);
    
}