@php
$user = $user ?? auth()->user();
$tab = request('tab', 'general');

$initials = collect(preg_split('/\s+/', trim($user?->name ?? 'U')))
->filter()
->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
->take(2)
->join('');

$avatarUrl = $user && $user->avatar_path
? asset('storage/' . $user->avatar_path)
: null;

$bannerUrl = $user && isset($user->banner_path) && $user->banner_path
? asset('storage/' . $user->banner_path)
: null;

$employeeProfile = $user?->employeeProfile;
$recruiterProfile = $user?->recruiterProfile;
$initials = collect(preg_split('/\s+/', trim($user?->name ?? 'U')))
->filter()
->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
->take(2)
->join('');

$isRecruiter = $user?->hasRole('recruiter');

$roleText = $isRecruiter ? 'Verified Recruiter' : 'Candidate';
@endphp
<x-recruitconnect-layout>
    <div class="flex flex-col gap-2 mb-8">
        <h1 class="text-3xl font-black leading-tight tracking-[-0.033em]">Account Settings</h1>
        <p class="text-[#617589] text-base font-normal">Manage your profile information and security preferences.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- Side Navigation --}}
        <aside class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-[#f0f2f4] overflow-hidden">

                {{-- (Optionnel) mini bande comme sur ton design --}}
                <div class="h-3 bg-[#137fec]/10"></div>

                <div class="p-4">
                    {{-- Header user --}}
                    <div class="flex items-center gap-3">
                        {{-- Avatar --}}
                        <div class="size-12 rounded-full bg-[#137fec] text-white font-extrabold flex items-center justify-center">
                            {{ $initials }}
                        </div>

                        {{-- Name + role --}}
                        <div class="leading-tight">
                            <div class="text-sm font-bold text-[#111418]">
                                {{ $user->name }}
                            </div>

                            <div class="text-xs text-[#617589] flex items-center gap-1 mt-1">
                                @if($isRecruiter)
                                <span class="material-symbols-outlined text-[16px] text-[#137fec]">verified</span>
                                @endif
                                <span>{{ $roleText }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Menu --}}
                    <nav class="flex flex-col gap-2 mt-4">
                        <a href="{{ route('profile.edit', ['tab' => 'general']) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                           {{ ($tab ?? 'general') === 'general'
                                ? 'bg-[#137fec]/10 text-[#137fec] font-bold'
                                : 'text-[#617589] hover:bg-[#f6f7f8]' }}">
                            <span class="material-symbols-outlined">person</span>
                            <span class="text-sm">General Profile</span>
                        </a>
                        <a href="{{ route('profile.edit', ['tab' => 'cv']) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                           {{ ($tab ?? 'general') === 'cv'
                                ? 'bg-[#137fec]/10 text-[#137fec] font-bold'
                                : 'text-[#617589] hover:bg-[#f6f7f8]' }}">
                            <span class="material-symbols-outlined">work</span>
                            <span class="text-sm">CV</span>
                        </a>
                        <a href="{{ route('profile.edit', ['tab' => 'security']) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors
                           {{ ($tab ?? 'general') === 'security'
                                ? 'bg-[#137fec]/10 text-[#137fec] font-bold'
                                : 'text-[#617589] hover:bg-[#f6f7f8]' }}">
                            <span class="material-symbols-outlined">lock</span>
                            <span class="text-sm">Security &amp; Password</span>
                        </a>
                    </nav>
                </div>
            </div>
        </aside>
        {{-- Main Content --}}
        <div class="lg:col-span-9 space-y-8">

            {{-- SECTION: GENERAL --}}
            @if($tab === 'general')
            <section class="bg-white rounded-xl shadow-sm border border-[#f0f2f4] overflow-hidden">
                {{-- ACCOUNT VERIFICATION --}}
                <div class="mb-8 rounded-xl border border-[#f0f2f4] p-5 bg-[#f9fafb]">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold flex items-center gap-2">
                                Account Verification
                                @if($user->is_verified)
                                <span class="material-symbols-outlined text-[#137fec]">verified</span>
                                @endif
                            </h3>

                            @if($user->is_verified)
                            <p class="text-sm text-green-700 mt-1">
                                Your account is verified. This badge increases your credibility.
                            </p>
                            @else
                            <p class="text-sm text-[#617589] mt-1">
                                Verify your account to gain trust and visibility.
                            </p>
                            @endif
                        </div>

                        {{-- STATUS BADGE --}}
                        @if($user->is_verified)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            Verified
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                            Not Verified
                        </span>
                        @endif
                    </div>

                    {{-- ACTION --}}
                    @if(!$user->is_verified)
                    <form method="POST" action="{{ route('verification.checkout') }}" class="mt-4">
                        @csrf
                        <button
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-bold
                       bg-[#137fec] text-white hover:opacity-90 transition-all shadow-md">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            Get Verified ($10)
                        </button>
                    </form>
                    @endif
                </div>

                <h2 class="text-xl font-bold p-6 border-b border-[#f0f2f4]">Profile Information</h2>

                <div class="p-6">
                    {{-- Success --}}
                    @if (session('status') === 'profile-updated')
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 text-green-700 px-4 py-3 text-sm">
                        Profile saved successfully.
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-semibold mb-2">Full Name</label>
                            <input name="name" value="{{ old('name', $user->name) }}"
                                class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                            @error('name') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Email Address</label>
                            <input name="email" type="email" value="{{ old('email', $user->email) }}"
                                class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                            @error('email') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold mb-2">Professional Bio</label>
                            <textarea name="bio" rows="4"
                                class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]"
                                placeholder="Tell candidates about yourself or your firm...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Employee : speciality --}}
                        @if($user->hasRole('employee'))
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold mb-2">Speciality</label>
                            <select name="speciality_id"
                                class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                                <option value="">-- Choose a speciality --</option>
                                @foreach($specialities as $sp)
                                <option value="{{ $sp->id }}"
                                    @selected(old('speciality_id', $employeeProfile?->speciality_id) == $sp->id)>
                                    {{ $sp->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('speciality_id') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        {{-- Recruiter : company --}}
                        @if($user->hasRole('recruiter'))
                        <div>
                            <label class="block text-sm font-semibold mb-2">Company Name</label>
                            <input name="company_name" value="{{ old('company_name', $recruiterProfile?->company_name) }}"
                                class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Website</label>
                            <input name="website" value="{{ old('website', $recruiterProfile?->website) }}"
                                class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                        </div>
                        @endif

                        <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                            <a href="{{ route('profile.edit', ['tab' => 'general']) }}"
                                class="px-6 py-2 rounded-lg text-sm font-bold border border-[#f0f2f4] hover:bg-[#f6f7f8] transition-colors">
                                Cancel
                            </a>
                            <button class="px-6 py-2 rounded-lg text-sm font-bold bg-[#137fec] text-white hover:opacity-90 transition-colors" type="submit">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </section>
            @endif
            @if(($tab ?? 'general') === 'cv')
            @include('profile.partials.cv')
            @endif

            {{-- SECTION: SECURITY --}}
            @if($tab === 'security')
            <section class="bg-white rounded-xl shadow-sm border border-[#f0f2f4] overflow-hidden">
                <div class="p-6 border-b border-[#f0f2f4] flex items-center justify-between">
                    <h2 class="text-xl font-bold">Security &amp; Password</h2>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">shield</span> Enabled
                    </span>
                </div>

                <div class="p-6">
                    @if (session('status') === 'password-updated')
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 text-green-700 px-4 py-3 text-sm">
                        Password updated successfully.
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" class="max-w-2xl space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold mb-2">Current Password</label>
                            <input name="current_password" type="password"
                                class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                            @if($errors->updatePassword?->has('current_password'))
                            <p class="text-xs text-red-600 mt-2">{{ $errors->updatePassword->first('current_password') }}</p>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold mb-2">New Password</label>
                                <input name="password" type="password"
                                    class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                                @if($errors->updatePassword?->has('password'))
                                <p class="text-xs text-red-600 mt-2">{{ $errors->updatePassword->first('password') }}</p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-2">Confirm New Password</label>
                                <input name="password_confirmation" type="password"
                                    class="w-full bg-[#f6f7f8] border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#137fec]">
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button class="px-8 py-3 rounded-lg text-sm font-bold bg-[#137fec] text-white hover:opacity-90 transition-all shadow-md active:scale-[0.98]" type="submit">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </section>
            @endif
        </div>
    </div>
</x-recruitconnect-layout>