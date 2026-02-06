<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\OfferLike;
use Illuminate\Http\RedirectResponse;

class OfferLikeController extends Controller
{
    public function toggle(JobOffer $offer): RedirectResponse
    {
        $userId = auth()->id();

        $like = OfferLike::query()
            ->where('job_offer_id', $offer->id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            OfferLike::create([
                'job_offer_id' => $offer->id,
                'user_id' => $userId,
            ]);
        }

        return back();
    }
}
