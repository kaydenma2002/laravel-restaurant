<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\PhoneVerification;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $data = PhoneVerification::Where('phone', $request->phone)->orderBy('created_at', 'desc')->first();
        
            if (intval($data->verify_code) === intval($request->verify_code)) {
                return Reservation::create([
                    'phone' => $data->phone,
                    'table' => $request->table,
                    'date' => $request->date
                ]);
            } else {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Invalid phone verification code'
                ]);
            }
    }
}
