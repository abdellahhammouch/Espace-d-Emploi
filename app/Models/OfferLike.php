<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferLike extends Model
{
    use HasFactory;

    protected $fillable = ['job_offer_id', 'user_id'];

    public function offer()
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(OfferLike::class, 'job_offer_id');
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }
}
