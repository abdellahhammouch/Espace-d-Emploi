<x-app-layout>
    <x-slot name="header">
        Offres d’emploi
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 space-y-6">
        <form class="flex flex-col md:flex-row gap-3" method="GET" action="{{ route('offers.index') }}">
            <input name="q" value="{{ $q }}" class="w-full rounded-xl border-slate-200" placeholder="Rechercher (titre, ville, description)..." />
            <select name="contract_type_id" class="rounded-xl border-slate-200">
                <option value="">Type contrat</option>
                @foreach($contractTypes as $ct)
                    <option value="{{ $ct->id }}" @selected($contractTypeId == $ct->id)>{{ $ct->name }}</option>
                @endforeach
            </select>
            <button class="rounded-xl px-5 py-2 bg-slate-900 text-white">Chercher</button>
        </form>

        <div class="space-y-5">
            @forelse($offers as $offer)
                @include('offers._post', ['offer' => $offer])
            @empty
                <p class="text-sm text-[#617589]">Aucune offre disponible.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
