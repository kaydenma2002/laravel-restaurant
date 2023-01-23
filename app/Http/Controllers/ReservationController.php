<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ReservationInterface;
use Illuminate\Support\Facades\Redis;

class ReservationController extends Controller
{
    private $reservationInterface;
    public function __construct(ReservationInterface $reservationInterface){
        $this->reservationInterface = $reservationInterface;
    }
    public function create(Request $request){
        return $this->reservationInterface->create($request);
    }
}
