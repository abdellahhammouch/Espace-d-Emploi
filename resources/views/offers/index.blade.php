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

        <div class="grid md:grid-cols-3 gap-5">
            @foreach($offers as $offer)
                <a href="{{ route('offers.show', $offer) }}" class="block bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-sm transition">
                    <img class="w-full h-44 object-cover" src="{{ asset('storage/'.$offer->image_path) }}" alt="">
                    <div class="p-4 space-y-1">
                        <div class="font-bold text-slate-900">{{ $offer->title }}</div>
                        <div class="text-sm text-slate-500">
                            {{ optional($offer->recruiter->recruiterProfile)->company_name ?? 'Entreprise' }} • {{ $offer->place }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $offer->contractType->name ?? '' }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div>
            {{ $offers->links() }}
        </div>
    </div>
</x-app-layout>
