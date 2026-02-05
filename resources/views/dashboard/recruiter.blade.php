<x-app-layout>
    <x-slot name="header">
        Recruiter Dashboard
    </x-slot>

    @php
        $me = auth()->user();

        $open = \App\Models\JobOffer::where('recruiter_id', $me->id)->where('is_closed', false)->count();
        $closed = \App\Models\JobOffer::where('recruiter_id', $me->id)->where('is_closed', true)->count();

        $offerIds = \App\Models\JobOffer::where('recruiter_id', $me->id)->pluck('id');
        $apps = \App\Models\Application::whereIn('job_offer_id', $offerIds)->count();

        $latest = \App\Models\JobOffer::where('recruiter_id', $me->id)
            ->withCount('applications')
            ->latest()
            ->limit(6)
            ->get();
    @endphp

    <div class="space-y-6">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('recruiter.offers.create') }}"
               class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-primary text-white font-extrabold shadow-soft hover:opacity-95 transition">
                + Créer une offre
            </a>
            <a href="{{ route('recruiter.offers.index') }}"
               class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-white border border-[#f0f2f4] font-extrabold hover:border-primary/30 transition">
                Mes offres
            </a>
        </div>

        {{-- Livewire Search (Dashboard) --}}
        <section class="bg-transparent">
            <livewire:dashboard-user-search />
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-[#f0f2f4] p-5 shadow-soft">
                <p class="text-xs font-bold text-muted uppercase tracking-wider">Offres ouvertes</p>
                <p class="mt-2 text-3xl font-black">{{ $open }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-[#f0f2f4] p-5 shadow-soft">
                <p class="text-xs font-bold text-muted uppercase tracking-wider">Candidatures reçues</p>
                <p class="mt-2 text-3xl font-black">{{ $apps }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-[#f0f2f4] p-5 shadow-soft">
                <p class="text-xs font-bold text-muted uppercase tracking-wider">Offres clôturées</p>
                <p class="mt-2 text-3xl font-black">{{ $closed }}</p>
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-[#f0f2f4] shadow-soft overflow-hidden">
            <div class="p-5 flex items-center justify-between border-b border-[#f0f2f4]">
                <h2 class="font-extrabold text-ink">Offres récentes</h2>
                <a class="text-sm font-bold text-primary hover:underline" href="{{ route('recruiter.offers.index') }}">Voir tout</a>
            </div>

            <div class="divide-y divide-[#f0f2f4]">
                @forelse($latest as $offer)
                    <div class="p-5 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-extrabold text-ink truncate">{{ $offer->title }}</p>
                            <p class="text-sm text-muted truncate">
                                {{ $offer->place }} • {{ $offer->is_closed ? 'Clôturée' : 'Ouverte' }} • {{ $offer->applications_count }} candidatures
                            </p>
                        </div>

                        <div class="flex gap-2 shrink-0">
                            <a class="px-4 py-2 rounded-xl bg-background-light border border-[#f0f2f4] font-bold hover:border-primary/30 transition"
                               href="{{ route('recruiter.offers.applications', $offer) }}">
                                Candidatures
                            </a>
                            <a class="px-4 py-2 rounded-xl bg-background-light border border-[#f0f2f4] font-bold hover:border-primary/30 transition"
                               href="{{ route('recruiter.offers.edit', $offer) }}">
                                Modifier
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-sm text-muted">Aucune offre créée pour le moment.</div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
