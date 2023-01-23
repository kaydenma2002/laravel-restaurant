<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\StripeInterface;

class StripePaymentController extends Controller
{
    private $stripeInterface;
    public function __construct(StripeInterface $stripeInterface ){
        $this->stripeInterface = $stripeInterface;
    }
    public function stripePost(Request $request){
        return $this->stripeInterface->stripePost($request);
    }
}
