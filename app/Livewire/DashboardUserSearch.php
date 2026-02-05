<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendship;

class DashboardUserSearch extends Component
{
    public string $q = '';
    public int $limit = 8;

    public function goToSearch()
    {
        $q = trim($this->q);

        return redirect()->route('users.search', [
            'q' => $q !== '' ? $q : null,
        ]);
    }

    public function sendRequest(int $userId): void
    {
        $me = auth()->id();
        if (!$me || $userId === $me) return;

        // déjà amis ?
        $alreadyFriend = Friendship::query()
            ->where('user_id', $me)
            ->where('friend_id', $userId)
            ->exists();

        if ($alreadyFriend) return;

        // si l'autre t'a déjà envoyé une demande => on accepte direct
        $incoming = FriendRequest::query()
            ->where('sender_id', $userId)
            ->where('receiver_id', $me)
            ->where('status', 'pending')
            ->first();

        if ($incoming) {
            $this->acceptRequest((int) $incoming->id);
            return;
        }

        // sinon on envoie la demande
        FriendRequest::query()->firstOrCreate(
            ['sender_id' => $me, 'receiver_id' => $userId],
            ['status' => 'pending']
        );
    }

    public function acceptRequest(int $requestId): void
    {
        $me = auth()->id();
        if (!$me) return;

        $req = FriendRequest::query()->find($requestId);
        if (!$req) return;

        // sécurité : seul le receiver peut accepter
        if ((int) $req->receiver_id !== (int) $me) return;
        if ($req->status !== 'pending') return;

        $req->update(['status' => 'accepted']);

        // on crée l'amitié dans les 2 sens
        Friendship::query()->updateOrCreate([
            'user_id' => $req->sender_id,
            'friend_id' => $req->receiver_id,
        ]);

        Friendship::query()->updateOrCreate([
            'user_id' => $req->receiver_id,
            'friend_id' => $req->sender_id,
        ]);
    }

    public function declineRequest(int $requestId): void
    {
        $me = auth()->id();
        if (!$me) return;

        $req = FriendRequest::query()->find($requestId);
        if (!$req) return;

        if ((int) $req->receiver_id !== (int) $me) return;
        if ($req->status !== 'pending') return;

        $req->update(['status' => 'declined']);
    }

    public function render()
    {
        $me = auth()->id();

        // maps status
        $friendIds = $me
            ? Friendship::query()->where('user_id', $me)->pluck('friend_id')->all()
            : [];

        $sentPendingIds = $me
            ? FriendRequest::query()
                ->where('sender_id', $me)
                ->where('status', 'pending')
                ->pluck('receiver_id')->all()
            : [];

        $incomingPendingMap = $me
            ? FriendRequest::query()
                ->where('receiver_id', $me)
                ->where('status', 'pending')
                ->pluck('id', 'sender_id') // [sender_id => request_id]
                ->toArray()
            : [];

        $q = trim($this->q);
        $results = collect();

        if ($me && $q !== '') {
            $results = User::query()
                ->with(['employeeProfile.speciality', 'recruiterProfile'])
                ->where('id', '!=', $me)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'ilike', "%{$q}%")
                        ->orWhere('email', 'ilike', "%{$q}%")
                        ->orWhereHas('recruiterProfile', fn ($r) => $r->where('company_name', 'ilike', "%{$q}%"))
                        ->orWhereHas('employeeProfile', function ($e) use ($q) {
                            $e->where('speciality', 'ilike', "%{$q}%")
                              ->orWhereHas('speciality', fn ($s) => $s->where('name', 'ilike', "%{$q}%"));
                        });
                })
                ->limit($this->limit)
                ->get();
        }

        return view('livewire.dashboard-user-search', [
            'results' => $results,
            'friendIds' => $friendIds,
            'sentPendingIds' => $sentPendingIds,
            'incomingPendingMap' => $incomingPendingMap,
        ]);
    }
}
