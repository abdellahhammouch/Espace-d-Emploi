<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOffer extends Model
{
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
}
