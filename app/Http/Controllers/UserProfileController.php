<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $me = auth()->user();

        if (!$me) {
            return view('users.show', [
                'user' => $user,
                'relation' => 'guest',
                'incomingRequest' => null,
            ]);
        }

        if ($me->id === $user->id) {
            return view('users.show', [
                'user' => $user,
                'relation' => 'self',
                'incomingRequest' => null,
            ]);
        }

        $areFriends = DB::table('friendships')
            ->where(function ($q) use ($me, $user) {
                $q->where('user_id', $me->id)->where('friend_id', $user->id);
            })
            ->orWhere(function ($q) use ($me, $user) {
                $q->where('user_id', $user->id)->where('friend_id', $me->id);
            })
            ->exists();

        $sent = FriendRequest::query()
            ->where('sender_id', $me->id)
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->first();

        $incoming = FriendRequest::query()
            ->where('sender_id', $user->id)
            ->where('receiver_id', $me->id)
            ->where('status', 'pending')
            ->first();

        $relation = 'none';
        if ($areFriends) $relation = 'connected';
        elseif ($incoming) $relation = 'incoming';
        elseif ($sent) $relation = 'pending';

        return view('users.show', [
            'user' => $user,
            'relation' => $relation,
            'incomingRequest' => $incoming,
        ]);
    }
}
