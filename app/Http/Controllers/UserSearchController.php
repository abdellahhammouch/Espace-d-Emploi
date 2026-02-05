<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendship;

class UserSearchController extends Controller
{
    public function results(Request $request)
    {
        $me = $request->user();
        $q = trim((string) $request->query('q', ''));

        $friendIds = Friendship::query()
            ->where('user_id', $me->id)
            ->pluck('friend_id')
            ->all();

        $sentPendingIds = FriendRequest::query()
            ->where('sender_id', $me->id)
            ->where('status', 'pending')
            ->pluck('receiver_id')
            ->all();

        $incomingPendingMap = FriendRequest::query()
            ->where('receiver_id', $me->id)
            ->where('status', 'pending')
            ->pluck('id', 'sender_id')
            ->toArray();

        $users = User::query()
            ->with(['employeeProfile.speciality', 'recruiterProfile'])
            ->where('id', '!=', $me->id)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'ilike', "%{$q}%")
                        ->orWhere('email', 'ilike', "%{$q}%")
                        ->orWhereHas('recruiterProfile', fn ($r) => $r->where('company_name', 'ilike', "%{$q}%"))
                        ->orWhereHas('employeeProfile', function ($e) use ($q) {
                            $e->where('speciality', 'ilike', "%{$q}%")
                              ->orWhereHas('speciality', fn ($s) => $s->where('name', 'ilike', "%{$q}%"));
                        });
                });
            })
            ->orderBy('name')
            ->get();

        return view('search.results', [
            'q' => $q,
            'users' => $users,
            'friendIds' => $friendIds,
            'sentPendingIds' => $sentPendingIds,
            'incomingPendingMap' => $incomingPendingMap,
        ]);
    }
}
