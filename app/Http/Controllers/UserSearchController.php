<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));

        $users = collect();

        if ($q !== '') {
            $users = User::query()
                ->where('name', 'ilike', "%{$q}%")
                ->orWhere('email', 'ilike', "%{$q}%")
                ->limit(15)
                ->get();
        }

        return view('users.search', compact('q', 'users'));
    }
}

