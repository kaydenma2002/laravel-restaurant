<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Events\Message;
use OpenAI\Laravel\Facades\OpenAI;

use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $result = OpenAI::completions()->create(
            [
                'model' => 'text-davinci-003',
                'prompt' => $request->message,
            ],

        );
        $chat = new Chat([
            'message' => $request->message,
            'reply' => $result['choices'][0]['text'],
            'user_id' => Auth::user()->id
        ]);

        $chat->save();
        event(new Message(Auth::user()->id, $chat));
        return response()->json($result);
    }
    public function getAllChat()
    {
        return Chat::with('user')->where('user_id', Auth::user()->id)->get();
    }
}
