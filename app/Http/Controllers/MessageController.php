<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private $message;

    public function __construct(Message $message, User $user){
        $this->message = $message;
        $this->user = $user;
    }

    public function getRoom($user_id){
        $user = $this->user->findOrFail($user_id);
        // $messages_received = $this->messages->where('receiver_id', Auth::user()->id)->where('sender_id', $user_id)->oldest()->get();
        // $messages_sent = $this->message->where('sender_id', Auth::user()->id)->where('receiver_id', $user_id)->oldest()->get();
        $messages = $this->message->where(function ($query) use ($user_id){
                    $query->where('receiver_id', Auth::user()->id)->where('sender_id', $user_id);
                })->orWhere(function ($query) use ($user_id){
                    $query->where('sender_id', Auth::user()->id)->where('receiver_id', $user_id);
                })->oldest()->get();

        return view('users.messages.room')->with('user', $user)->with('messages', $messages);
    }

    public function sendMessage(Request $request, $user_id){
        $request->validate([
            'message' => 'required|min:1'
        ]);

        $this->message->sender_id = Auth::user()->id;
        $this->message->receiver_id = $user_id;
        $this->message->message = $request->message;
        $this->message->save();

        return redirect()->back();
    }
}