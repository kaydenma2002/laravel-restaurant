<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Message;
use Illuminate\Support\Facades\Auth;
class ChatController extends Controller
{
    public function messages(Request $request)
    {
        $message = $request->input('message');
        $email = Auth::user()->email;
        $id = Auth::user()->id;
        event(new Message([
            'email' => $email,
            'message' => $message,
            'id' => $id
        ]));

        return response()->json(['status' => 'Message sent!']);
    }
}
