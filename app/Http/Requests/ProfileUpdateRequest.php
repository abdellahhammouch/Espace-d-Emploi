<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $user = $this->user();

        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'company_name' => [$user->hasRole('recruiter') ? 'required' : 'nullable', 'string', 'max:255'],
            'website'      => ['nullable', 'url', 'max:255'],
            'location'     => ['nullable', 'string', 'max:255'],
            'speciality_id' => ['nullable', 'integer', 'exists:specialities,id'],
        ];
    }
}

