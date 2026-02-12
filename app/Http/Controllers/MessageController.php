<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Friendship;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function Livewire\of;



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

        // dd($friends);

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

        // dd($messages) ; 

        return view('chat.show', compact('messages', 'friends', 'receiver'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'content' => 'nullable | string |',
            'receiver_id' => 'required | exists:users,id',
            'attachment' => 'nullable | max:20480',
        ]);

        $filepath = null;
        $typeFile = 'text';
        
        if ($request->hasFile('attachment')) {
            // dd($request->all() , $request -> hasFile('attachment')) ;
            $file = $request->file('attachment');

            $filepath = $file->store('attachment', 'public');
            
            $filepath = basename($filepath) ; 

            $mime = $file->getMimeType();

            if (str_starts_with($mime, 'image/')) {
                $typeFile = 'image';
            } else if (str_starts_with($mime, 'video/')) {
                $typeFile = 'video';
            } else {
                $typeFile = 'file';
            }

        }

        if ($request->receiver_id === Auth::id()) {
            return back()->with('error', 'no msg for your self');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->input('content'),
            'type' => $typeFile,
            'file_path' => $filepath,
        ]);
        
        
        // dd($message);

        broadcast(new MessageSent($message));

        return back();
    }

    public function allFreinds()
    {
    }
}
