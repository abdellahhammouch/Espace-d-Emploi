<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConnectionsController extends Controller
{
    public function index(Request $request)
    {
        $me = $request->user();
        $tab = $request->query('tab', 'friends'); // friends|pending|suggestions
        $q = trim((string) $request->query('q', ''));
        
        $friendIds = Friendship::query()
            ->where('user_id', $me->id)
            ->pluck('friend_id');

        $pendingReceived = FriendRequest::query()
            ->with(['sender.employeeProfile.speciality', 'sender.recruiterProfile'])
            ->where('receiver_id', $me->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingSentIds = FriendRequest::query()
            ->where('sender_id', $me->id)
            ->where('status', 'pending')
            ->pluck('receiver_id');

        $pendingReceivedSenderIds = $pendingReceived->pluck('sender_id');

        $friends = User::query()
            ->with(['employeeProfile.speciality', 'recruiterProfile'])
            ->whereIn('id', $friendIds)
            ->when($q !== '', fn($query) => $query->where('name', 'ilike', "%{$q}%"))
            ->orderBy('name')
            ->get();

        $suggestions = User::query()
            ->with(['employeeProfile.speciality', 'recruiterProfile'])
            ->where('id', '!=', $me->id)
            ->whereNotIn('id', $friendIds)
            ->whereNotIn('id', $pendingSentIds)
            ->whereNotIn('id', $pendingReceivedSenderIds)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'ilike', "%{$q}%")
                        ->orWhereHas('employeeProfile', function ($q2) use ($q) {
                            $q2->where('speciality', 'ilike', "%{$q}%")
                               ->orWhereHas('speciality', fn($q3) => $q3->where('name', 'ilike', "%{$q}%"));
                        })
                        ->orWhereHas('recruiterProfile', function ($q2) use ($q) {
                            $q2->where('company_name', 'ilike', "%{$q}%");
                        });
                });
            })
            ->limit(12)
            ->get();

        return view('connections.index', [
            'tab' => $tab,
            'q' => $q,
            'friends' => $friends,
            'pendingReceived' => $pendingReceived,
            'suggestions' => $suggestions,
            'friendsCount' => $friendIds->count(),
            'pendingCount' => $pendingReceived->count(),
            'suggestionsCount' => $suggestions->count(),
        ]);
    }

    public function send(User $user, Request $request)
    {
        $me = $request->user();
        abort_if($user->id === $me->id, 403);

        $alreadyFriend = Friendship::query()
            ->where('user_id', $me->id)
            ->where('friend_id', $user->id)
            ->exists();

        if ($alreadyFriend) return back();

        $alreadyPending = FriendRequest::query()
            ->where('status', 'pending')
            ->where(function ($q) use ($me, $user) {
                $q->where(function ($q1) use ($me, $user) {
                    $q1->where('sender_id', $me->id)->where('receiver_id', $user->id);
                })->orWhere(function ($q2) use ($me, $user) {
                    $q2->where('sender_id', $user->id)->where('receiver_id', $me->id);
                });
            })
            ->exists();

        if ($alreadyPending) return back();

        FriendRequest::create([
            'sender_id' => $me->id,
            'receiver_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('status', 'request-sent');
    }

    public function accept(FriendRequest $friendRequest, Request $request)
    {
        $me = $request->user();

        abort_if($friendRequest->receiver_id !== $me->id, 403);
        abort_if($friendRequest->status !== 'pending', 403);

        DB::transaction(function () use ($friendRequest) {
            $friendRequest->update(['status' => 'accepted']);

            Friendship::firstOrCreate([
                'user_id' => $friendRequest->sender_id,
                'friend_id' => $friendRequest->receiver_id,
            ]);

            Friendship::firstOrCreate([
                'user_id' => $friendRequest->receiver_id,
                'friend_id' => $friendRequest->sender_id,
            ]);
        });

        return back()->with('status', 'request-accepted');
    }

    public function decline(FriendRequest $friendRequest, Request $request)
    {
        $me = $request->user();

        abort_if($friendRequest->receiver_id !== $me->id, 403);
        abort_if($friendRequest->status !== 'pending', 403);

        $friendRequest->update(['status' => 'declined']);

        return back()->with('status', 'request-declined');
    }
}
