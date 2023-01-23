<?php

namespace App\Interfaces;

interface StripeInterface
{
    public function stripePost($request);
}