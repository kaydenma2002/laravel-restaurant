<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Message;

class ChatController extends Controller
{
    public function messages(Request $request)
    {
        event(new Message($request->username, $request->message));
        return [];
    }
}
