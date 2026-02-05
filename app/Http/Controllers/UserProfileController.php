<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load([
            'employeeProfile.speciality',
            'employeeProfile.experiences',
            'employeeProfile.educations',
            'recruiterProfile',
        ]);

        return view('users.show', compact('user'));
    }
}
