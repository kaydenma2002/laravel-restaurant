<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

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
        $recipient_id = $request->recipient_id;
        

        $PrivateChat = new PrivateChat;
        $PrivateChat->sender_id = $sender->id;
        $PrivateChat->recipient_id = $recipient_id;
        $PrivateChat->message = $message;
        $PrivateChat->type = $request->type;
        $PrivateChat->created_at = Carbon::now()->toDateTimeString();
        $PrivateChat->save();
        if($request->type != 0){
            $message = Str::limit($message,9216);
        }
        broadcast(new PrivateChatEvent($sender->id,$recipient_id,$message))->toOthers();

        return response()->json(['status' => 'Message sent!']);
    }
    public function findVoice(Request $request){
        return PrivateChat::where('message','like','%' . $request->message . '%')->get();
    }
    public function getPrivateChat(Request $request){
        return PrivateChat::where([['recipient_id',$request->recipient_id],['sender_id',$request->sender_id]])->orWhere([['recipient_id',$request->sender_id],['sender_id',$request->recipient_id]])->orderBy('id', 'ASC')->get();
    }
}
