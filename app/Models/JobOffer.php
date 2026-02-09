<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class JobOffer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'recruiter_id',
        'contract_type_id',
        'title',
        'place',
        'start_date',
        'description',
        'image_path',
        'is_closed',
        'closed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'is_closed' => 'boolean',
        'closed_at' => 'datetime',
    ];

    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function contractType(): BelongsTo
    {
        return $this->belongsTo(ContractType::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
    public function likes(): HasMany
    {
        return $this->hasMany(\App\Models\OfferLike::class, 'job_offer_id');
    }
}
