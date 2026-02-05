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

        {{-- ✅ Livewire Search (Dashboard) --}}
        <section class="bg-transparent">
            <livewire:dashboard-user-search />
        </section>

        {{-- Latest offers --}}
        <section class="bg-white rounded-2xl border border-[#f0f2f4] shadow-soft overflow-hidden">
            <div class="p-5 flex items-center justify-between border-b border-[#f0f2f4]">
                <h2 class="font-extrabold text-ink">Offres récentes</h2>
                <a class="text-sm font-bold text-primary hover:underline" href="{{ route('offers.index') }}">Voir tout</a>
            </div>

            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($latestOffers as $offer)
                    @php
                        $company = optional($offer->recruiter->recruiterProfile)->company_name ?? 'Entreprise';
                    @endphp

                    <a href="{{ route('offers.show', $offer) }}"
                       class="group rounded-2xl border border-[#f0f2f4] hover:border-primary/30 bg-background-light/40 p-4 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-extrabold text-ink truncate">{{ $offer->title }}</p>
                                <p class="text-sm text-muted truncate">{{ $company }} • {{ $offer->place }}</p>
                            </div>
                            <span class="shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                                {{ $offer->contractType?->name }}
                            </span>
                        </div>
                        <p class="mt-3 text-sm text-muted line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($offer->description, 120) }}
                        </p>
                        <p class="mt-3 text-sm font-bold text-primary">Voir l’offre →</p>
                    </a>
                @empty
                    <div class="text-sm text-muted">Aucune offre pour le moment.</div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
