<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        if (!in_array($provider, ['google', 'github'], true)) {
            abort(404);
        }

        $driver = Socialite::driver($provider);

        /*if ($provider === 'facebook') {
            $driver = $driver->scopes(['email']);
        }*/

        return $driver->redirect();
    }

    public function callback(string $provider)
    {
        if (!in_array($provider, ['google', 'github'], true)) {
            abort(404);
        }
        if (request()->has('error')) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'oauth' => request()->get('error_description') ?? 'Authentication cancelled.',
                ]);
        }

        $providerUser = Socialite::driver($provider)->stateless()->user();

        $providerId = $providerUser->getId();
        $email      = $providerUser->getEmail();
        $name       = $providerUser->getName() ?: $providerUser->getNickname() ?: 'User';
        $avatar     = $providerUser->getAvatar();

        $idColumn = $provider . '_id';

        $user = User::where($idColumn, $providerId)->first();

        if (!$user && $email) {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            $updates = [];

            if (!$user->{$idColumn}) $updates[$idColumn] = $providerId;
            if (!$user->email_verified_at) $updates['email_verified_at'] = now();
            if (!$user->avatar_path && $avatar) $updates['avatar_path'] = $avatar;

            if ($updates) $user->update($updates);

            Auth::login($user, true);
            if (!$user->hasRole('employee') && !$user->hasRole('recruiter')) {
                return redirect()->route('onboarding.role');
            }
            return redirect()->intended('/dashboard');
        }

        $user = User::create([
            'name' => $name,
            'email' => $email ?? (Str::uuid().'@no-email.local'),
            'password' => Hash::make(Str::random(40)),
            $idColumn => $providerId,
            'avatar_path' => $avatar,
            'email_verified_at' => now(),
        ]);

        Auth::login($user, true);
        return redirect('/dashboard');
    }
}
