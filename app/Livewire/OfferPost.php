<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobOffer;
use App\Models\OfferLike;
use Illuminate\Support\Facades\Storage;

class OfferPost extends Component
{
    public JobOffer $offer;

    public int $likesCount = 0;
    public bool $likedByMe = false;

    public function mount(JobOffer $offer): void
    {
        $this->offer = $offer;

        $this->likesCount = $offer->likes_count ?? $offer->likes()->count();

        $me = auth()->id();
        $this->likedByMe = $me
            ? $offer->likes()->where('user_id', $me)->exists()
            : false;
    }

    public function toggleLike(): void
    {
        abort_unless(auth()->check(), 403);

        $me = auth()->id();

        $like = OfferLike::query()
            ->where('job_offer_id', $this->offer->id)
            ->where('user_id', $me)
            ->first();

        if ($like) {
            $like->delete();
            $this->likedByMe = false;
        } else {
            OfferLike::create([
                'job_offer_id' => $this->offer->id,
                'user_id' => $me,
            ]);
            $this->likedByMe = true;
        }

        // recalcul sûr (évite bugs)
        $this->likesCount = $this->offer->likes()->count();

        // option: rafraîchir juste ce composant visuellement
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.offer-post');
    }
}
