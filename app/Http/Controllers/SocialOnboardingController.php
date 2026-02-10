<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployeeProfile;
use App\Models\RecruiterProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SocialOnboardingController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('employee') || $user->hasRole('recruiter')) {
            return redirect()->route('dashboard');
        }

        return view('auth.social-onboarding');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->hasRole('employee') || $user->hasRole('recruiter')) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'role' => ['required', Rule::in(['employee', 'recruiter'])],
            'location' => ['nullable', 'string', 'max:255'],

            'company_name' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],

            'speciality' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated['role'] === 'recruiter') {
            $request->validate(['company_name' => ['required', 'string', 'max:255']]);
        }

        if ($validated['role'] === 'employee') {
            $request->validate(['speciality' => ['required', 'string', 'max:255']]);
        }

        $user->update(['role' => $validated['role']]);
        $user->syncRoles([$validated['role']]);

        if ($validated['role'] === 'recruiter') {
            RecruiterProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $request->input('company_name'),
                    'website' => $request->input('website'),
                    'location' => $request->input('location'),
                ]
            );
        } else {
            EmployeeProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'speciality' => $request->input('speciality'),
                    'location' => $request->input('location'),
                ]
            );
        }

        return redirect()->route('dashboard');
    }
}
