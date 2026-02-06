<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferLike extends Model
{
    protected $fillable = ['job_offer_id', 'user_id'];

    public function offer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
