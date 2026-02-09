<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmployeeProfile;
use App\Models\RecruiterProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['employee', 'recruiter'])],

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'location' => ['nullable', 'string', 'max:255'],

            'company_name' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'speciality' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated['role'] === 'recruiter') {
            $request->validate([
                'company_name' => ['required', 'string', 'max:255'],
            ]);
        }

        if ($validated['role'] === 'employee') {
            $request->validate([
                'speciality' => ['required', 'string', 'max:255'],
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

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

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
