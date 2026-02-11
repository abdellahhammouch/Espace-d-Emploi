<?php

namespace App\Listeners;

use App\Events\JobOfferCreated;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewJobOfferNotification;

class SendJobOfferNotification
{
    public function handle(JobOfferCreated $event): void
    {
        $jobOffer = $event->jobOffer;

        User::role('employee')
            ->where('id', '!=', $jobOffer->recruiter_id)
            ->each(function (User $user) use ($jobOffer) {
                $user->notify(new NewJobOfferNotification($jobOffer));
            });

        Log::info('JobOfferCreated listener fired', [
            'job_offer_id' => $event->jobOffer->id,
        ]);
    }
}
