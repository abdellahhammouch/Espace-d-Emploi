<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Friendship;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class MessageController extends Controller
{

    public function index($id)
    {
        $myId = Auth::id();
        $receiverId = $id;

        $receiver = User::findOrFail($receiverId);

        $friends = Friendship::where('user_id', $myId)
            ->with('friend')
            ->get();


        $messages = Message::where(function ($query) use ($myId, $receiverId) {
            $query->where('sender_id', $myId)
                ->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($myId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', $myId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('messages', 'friends', 'receiver'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required | string |',
            'receiver_id' => 'required | exists:users,id'
        ]);

        if ($request->receiver_id === Auth::id()) {
            return back()->with('error', 'no msg for your self');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->input('content'),
        ]);


        broadcast(new MessageSent($message));

        // dd('EVENT SHOULD FIRE NOW' ,  $message);
        return back();
    }

    public function allFreinds() {}
}
