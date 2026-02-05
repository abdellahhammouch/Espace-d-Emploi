@props(['tab' => 'general'])

@php
    $user = auth()->user();

    $avatarUrl = $user && $user->avatar_path
        ? asset('storage/' . $user->avatar_path)
        : null;

    $roleLabel = $user?->hasRole('recruiter') ? 'Verified Recruiter' : 'Candidate';

    $isGeneral = $tab === 'general';
    $isSecurity = $tab === 'security';
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-[#f0f2f4] p-4">
    {{-- Header card --}}
    <div class="flex items-center gap-3 mb-4">
        <div class="size-12 rounded-full overflow-hidden bg-slate-100 flex items-center justify-center">
            @if($avatarUrl)
                <img src="{{ $avatarUrl }}" class="w-full h-full object-cover" alt="avatar">
            @else
                <span class="text-sm font-extrabold text-[#137fec]">
                    {{ mb_strtoupper(mb_substr($user->name,0,1)) }}
                </span>
            @endif
        </div>

        <div class="leading-tight">
            <div class="text-sm font-bold">{{ $user->name }}</div>
            <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                <span class="material-symbols-outlined text-[16px] text-[#137fec]">verified</span>
                {{ $roleLabel }}
            </div>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="space-y-1">
        <a href="{{ route('profile.edit', ['tab' => 'general']) }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition
                 {{ $isGeneral ? 'bg-[#137fec]/10 text-[#137fec]' : 'text-slate-600 hover:bg-[#f6f7f8]' }}">
            <span class="material-symbols-outlined">person</span>
            <span class="text-sm">General Profile</span>
        </a>

        <a href="{{ route('profile.edit', ['tab' => 'security']) }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition
                 {{ $isSecurity ? 'bg-[#137fec]/10 text-[#137fec]' : 'text-slate-600 hover:bg-[#f6f7f8]' }}">
            <span class="material-symbols-outlined">lock</span>
            <span class="text-sm">Security &amp; Password</span>
        </a>
    </nav>
</div>
