<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PrivateChatEvent;
use App\Models\PrivateChat;
use Carbon\Carbon;
class PrivateChatController extends Controller
{
    public function index(Request $request)
    {
        $sender = $request->user();
        $message = $request->input('message');
        $recipient = 2;
        $data = [
            'sender_id' => $sender->id,
            'recipient_id' => 2,
            'message' => $message,
            'created_at' => Carbon::now()->toDateTimeString(),
        ];

        PrivateChat::create($data);

        event(new PrivateChatEvent($sender->id,$recipient,$message));

        return response()->json(['status' => 'Message sent!']);
    }
}
