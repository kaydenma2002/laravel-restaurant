<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\ReservationInterface;
use App\Models\Reservation;

class ReservationRepository implements ReservationInterface
{
    public function create($request){
        return Reservation::create([
            'name' => $request->name,
            'company' => $request->company,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'email' => $request->email
        ]);
    }
}