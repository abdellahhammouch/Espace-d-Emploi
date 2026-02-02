<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('employee')) {
            return view('dashboard.employee');
        }

        if ($user->hasRole('recruiter')) {
            return view('dashboard.recruiter'); // on va le faire après
        }

        abort(403, 'Role not assigned.');
    }
}
