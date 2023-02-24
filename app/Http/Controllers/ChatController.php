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
        $message = $request->message;

        // Check if the user is trying to make a booking
        if (strpos($message, 'book') !== false) {

            // Prompt the user for the required information
            $prompt = "What is your name?";
            session(['booking_state' => 'get_name']);
        } else {
            $prompt = $message;
        }

        // Send the prompt to the OpenAI API for processing
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-001',
            'prompt' => $prompt,
            'max_tokens' => 128,
            'temperature' => 0,
        ]);

        // Get the AI response and update the prompt based on the booking state
        $reply = $result['choices'][0]['text'];
        $booking_state = session('booking_state');
        if ($booking_state == 'get_name') {
            session(['customer_name' => $reply]);
            $prompt = "What is your email address?";
            session(['booking_state' => 'get_email']);
        } elseif ($booking_state == 'get_email') {
            session(['customer_email' => $reply]);
            $prompt = "What is your preferred date and time?";
            session(['booking_state' => 'get_date_time']);
        } elseif ($booking_state == 'get_date_time') {
            session(['booking_date_time' => $reply]);
            $prompt = "Thanks! Your booking has been confirmed for {date_time}. We'll send a confirmation email to {email}.";
            $prompt = str_replace('{date_time}', session('booking_date_time'), $prompt);
            $prompt = str_replace('{email}', session('customer_email'), $prompt);
            session()->forget(['booking_state', 'customer_name', 'customer_email', 'booking_date_time']);
        }

        // Save the chat message to the database and broadcast it to other users
        $chat = new Chat([
            'message' => $message,
            'reply' => $reply,
            'user_id' => Auth::user()->id
        ]);
        $chat->save();
        event(new Message(Auth::user()->id, $chat));

        // Return the AI response to the client
        return response()->json($result);
    }
    public function getAllChat()
    {
        return Chat::with('user')->where('user_id', Auth::user()->id)->get();
    }
}
