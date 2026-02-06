<x-app-layout>
    <x-slot name="header">
        Bonjour, {{ auth()->user()->name }}
    </x-slot>

    @php
        $me = auth()->user();
        $openOffers = \App\Models\JobOffer::where('is_closed', false)->count();
        $myApps = \App\Models\Application::where('employee_id', $me->id)->count();

        $latestOffers = \App\Models\JobOffer::query()
            ->with(['recruiter.recruiterProfile', 'contractType'])
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_me' => fn($q) => $q->where('user_id', $me->id),
                'applications as applied_by_me' => fn($q) => $q->where('employee_id', $me->id),
            ])
            ->where('is_closed', false)
            ->latest()
            ->limit(6)
            ->get();
    @endphp

    <div class="space-y-6">
        {{-- Stats --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-[#f0f2f4] p-5 shadow-soft">
                <p class="text-xs font-bold text-muted uppercase tracking-wider">Offres ouvertes</p>
                <p class="mt-2 text-3xl font-black">{{ $openOffers }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-[#f0f2f4] p-5 shadow-soft">
                <p class="text-xs font-bold text-muted uppercase tracking-wider">Mes candidatures</p>
                <p class="mt-2 text-3xl font-black">{{ $myApps }}</p>
            </div>
            <a href="{{ route('profile.edit', ['tab' => 'cv']) }}"
               class="bg-white rounded-2xl border border-[#f0f2f4] p-5 shadow-soft hover:border-primary/30 transition">
                <p class="text-xs font-bold text-muted uppercase tracking-wider">Améliorer mon CV</p>
                <p class="mt-2 text-sm text-muted">Ajoute tes expériences et formations.</p>
                <p class="mt-3 inline-flex text-primary font-bold text-sm">Aller au CV →</p>
            </a>
        </section>

        {{-- Livewire Search (Dashboard) --}}
        <section class="bg-transparent">
            <livewire:dashboard-user-search />
        </section>

        {{-- Latest offers --}}
        <section class="bg-white rounded-2xl border border-[#f0f2f4] shadow-soft overflow-hidden">
            <div class="p-5 flex items-center justify-between border-b border-[#f0f2f4]">
                <h2 class="font-extrabold text-ink">Offres récentes</h2>
                <a class="text-sm font-bold text-primary hover:underline" href="{{ route('offers.index') }}">Voir tout</a>
            </div>

            <div class="p-5 space-y-5">
                @forelse($latestOffers as $offer)
                    @include('offers._post', ['offer' => $offer])
                @empty
                    <div class="text-sm text-muted">Aucune offre pour le moment.</div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
