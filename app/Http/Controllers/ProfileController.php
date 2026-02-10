<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Speciality;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load([
            'employeeProfile.experiences',
            'employeeProfile.educations',
            'recruiterProfile',
        ]);

        $tab = $request->query('tab', 'general');

        return view('profile.edit', [
            'user' => $user,
            'tab' => $tab,
            'specialities' => Speciality::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // 1) Update common user fields
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'bio' => $data['bio'] ?? null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 2) Update recruiter profile if recruiter
        if ($user->hasRole('recruiter')) {
            $user->recruiterProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $data['company_name'] ?? null,
                    'website'      => $data['website'] ?? null,
                    'location'     => $data['location'] ?? null,
                ]
            );
        }

        // 3) Update employee profile if employee
        if ($user->hasRole('employee')) {
            $user->employeeProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'speciality' => $data['speciality'] ?? null,
                    'location'   => $data['location'] ?? null,
                ]
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
