<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Support\Facades\DB;

class UserSearchBar extends Component
{
    #[Url(as: 'q')]
    public string $q = '';

    public function goToResults()
    {
        $q = trim($this->q);

        return redirect()->route('search.results', [
            'q' => $q !== '' ? $q : null,
        ]);
    }

    public function sendRequest(int $userId): void
    {
        $me = auth()->id();
        if (!$me || $userId === $me) return;

        $alreadyFriend = Friendship::query()
            ->where('user_id', $me)
            ->where('friend_id', $userId)
            ->exists();

        if ($alreadyFriend) return;

        $incoming = FriendRequest::query()
            ->where('sender_id', $userId)
            ->where('receiver_id', $me)
            ->where('status', 'pending')
            ->first();

        if ($incoming) {
            $this->acceptRequest((int) $incoming->id);
            return;
        }

        $alreadyPending = FriendRequest::query()
            ->where('status', 'pending')
            ->where(function ($q) use ($me, $userId) {
                $q->where(fn ($q1) => $q1->where('sender_id', $me)->where('receiver_id', $userId))
                  ->orWhere(fn ($q2) => $q2->where('sender_id', $userId)->where('receiver_id', $me));
            })
            ->exists();

        if ($alreadyPending) return;

        FriendRequest::create([
            'sender_id' => $me,
            'receiver_id' => $userId,
            'status' => 'pending',
        ]);
    }

    public function acceptRequest(int $requestId): void
    {
        $me = auth()->id();
        if (!$me) return;

        $req = FriendRequest::find($requestId);
        if (!$req) return;

        if ((int) $req->receiver_id !== (int) $me) return;
        if ($req->status !== 'pending') return;

        DB::transaction(function () use ($req) {
            $req->update(['status' => 'accepted']);

            Friendship::firstOrCreate([
                'user_id' => $req->sender_id,
                'friend_id' => $req->receiver_id,
            ]);

            Friendship::firstOrCreate([
                'user_id' => $req->receiver_id,
                'friend_id' => $req->sender_id,
            ]);
        });
    }

    public function declineRequest(int $requestId): void
    {
        $me = auth()->id();
        if (!$me) return;

        $req = FriendRequest::find($requestId);
        if (!$req) return;

        if ((int) $req->receiver_id !== (int) $me) return;
        if ($req->status !== 'pending') return;

        $req->update(['status' => 'declined']);
    }

    public function render()
    {
        $me = auth()->id();
        $q = trim($this->q);

        $friendIds = $me ? Friendship::where('user_id', $me)->pluck('friend_id')->all() : [];
        $sentPendingIds = $me ? FriendRequest::where('sender_id', $me)->where('status', 'pending')->pluck('receiver_id')->all() : [];
        $incomingPendingMap = $me ? FriendRequest::where('receiver_id', $me)->where('status', 'pending')->pluck('id', 'sender_id')->toArray() : [];

        $users = collect();

        if ($me && $q !== '') {
            $users = User::query()
                ->with(['employeeProfile.speciality', 'recruiterProfile'])
                ->where('id', '!=', $me)
                ->where(function ($sub) use ($q) {
                    $sub->where('name', 'ilike', "%{$q}%")
                        ->orWhere('email', 'ilike', "%{$q}%")
                        ->orWhereHas('recruiterProfile', fn ($r) => $r->where('company_name', 'ilike', "%{$q}%"))
                        ->orWhereHas('employeeProfile', function ($e) use ($q) {
                            $e->where('speciality', 'ilike', "%{$q}%")
                              ->orWhereHas('speciality', fn ($s) => $s->where('name', 'ilike', "%{$q}%"));
                        });
                })
                ->orderBy('name')
                ->get();
        }

        return view('livewire.user-search-bar', [
            'users' => $users,
            'q' => $q,
            'friendIds' => $friendIds,
            'sentPendingIds' => $sentPendingIds,
            'incomingPendingMap' => $incomingPendingMap,
        ]);
    }
}
