<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Events\ReservationBooked;
use App\Models\PhoneVerification;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $data = PhoneVerification::Where('phone', $request->phone)->where('type','1')->orderBy('created_at', 'desc')->first();
        
            if (intval($data->verify_code) === intval($request->verify_code)) {
                $reservation = Reservation::create([
                    'phone' => $data->phone,
                    'table' => $request->table,
                    'date' => $request->date
                ]);
                event(new ReservationBooked($reservation));
                return $reservation;
            } else {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Invalid phone verification code'
                ]);
            }
    }
    public function getAllReservations(){
        return Reservation::all();
    }
}
