<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProfile extends Model
{
    protected $fillable = [
        'user_id',
        'speciality',
        'speciality_id',
        'location',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function speciality()
    {
        return $this->belongsTo(\App\Models\Speciality::class);
    }
    public function experiences()
    {
        return $this->hasMany(\App\Models\Experience::class);
    }

    public function educations()
    {
        return $this->hasMany(\App\Models\Education::class);
    }
}
