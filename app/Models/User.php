<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'avatar_path',
        'verification_expires_at',
        'is_verified'
    ];

    protected $casts = [
    'verification_expires_at' => 'datetime',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employeeProfile(): HasOne
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function recruiterProfile(): HasOne
    {
        return $this->hasOne(RecruiterProfile::class);
    }

    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class, 'recruiter_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'employee_id');
    }

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id');
    }

    public function sentFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function receivedFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }
    public function offerLikes()
    {
        return $this->hasMany(\App\Models\OfferLike::class);
    }

    public function isCurrentlyVerified(): bool
{
    return $this->is_verified
        && $this->verification_expires_at
        && $this->verification_expires_at->isFuture();
}

}
