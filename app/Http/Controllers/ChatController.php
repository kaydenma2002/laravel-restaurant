<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Events\Message;
use OpenAI\Laravel\Facades\OpenAI;

use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = strtolower($request->message);
        if (!Str::contains($message, 'order') || !Str::contains($message, 'reservation')  ||!Str::contains($message, 'contact')) {
            $reply = "Please type something like: order, reservation, contact";
        } else {
            if (Str::contains($message, 'contact')) {
                $reply = $message;
            } elseif (Str::contains($message, 'reservation')) {
                $reply = $message;
            } elseif (Str::contains($message, 'order')) {
                $reply = $message;
            }
        }


        $chat = new Chat([
            'message' => $message,
            'reply' => $reply,
            'user_id' => Auth::user()->id
        ]);
        $chat->save();
        event(new Message(Auth::user()->id, $chat));

        // Return the AI response to the client
        return response()->json($chat);
    }
    public function getAllChat()
    {
        return Chat::with('user')->where('user_id', Auth::user()->id)->get();
    }
}
