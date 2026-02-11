<?php
namespace App\Events;

use App\Models\JobOffer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobOfferCreated
{
    use Dispatchable, SerializesModels;

    public JobOffer $jobOffer;

    public function __construct(JobOffer $jobOffer)
    {
        $this->jobOffer = $jobOffer;
    }
}
