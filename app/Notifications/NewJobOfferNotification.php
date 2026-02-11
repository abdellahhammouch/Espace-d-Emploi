<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewJobOfferNotification extends Notification
{
    use Queueable;

    public $jobOffer;

    public function __construct($jobOffer)
    {
        $this->jobOffer = $jobOffer;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'job_offer_id' => $this->jobOffer->id,
            'title' => $this->jobOffer->title,
            'place' => $this->jobOffer->place,
            'recruiter_id' => $this->jobOffer->recruiter_id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'job_offer_id' => $this->jobOffer->id,
            'title' => $this->jobOffer->title,
            'place' => $this->jobOffer->place,
            'recruiter_id' => $this->jobOffer->recruiter_id,
        ]);
    }
}
