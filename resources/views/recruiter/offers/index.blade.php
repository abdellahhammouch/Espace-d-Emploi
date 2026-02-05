<x-app-layout>
    <x-slot name="header">Mes Offres</x-slot>

    <div class="max-w-5xl mx-auto p-6 space-y-5">
        <div class="flex items-center justify-between">
            <a href="{{ route('recruiter.offers.create') }}" class="rounded-xl px-4 py-2 bg-slate-900 text-white">+ Nouvelle offre</a>
        </div>

        <div class="space-y-3">
            @foreach($offers as $offer)
                <div class="bg-white rounded-2xl border border-slate-200 p-4 flex items-center justify-between">
                    <div>
                        <div class="font-bold">{{ $offer->title }}</div>
                        <div class="text-sm text-slate-500">{{ $offer->place }} • {{ $offer->is_closed ? 'Clôturée' : 'Ouverte' }}</div>
                    </div>

                    <div class="flex gap-2">
                        <a class="rounded-xl px-3 py-2 border border-slate-200" href="{{ route('recruiter.offers.applications', $offer) }}">Candidatures</a>
                        <a class="rounded-xl px-3 py-2 border border-slate-200" href="{{ route('recruiter.offers.edit', $offer) }}">Modifier</a>

                        @if(!$offer->is_closed)
                            <form method="POST" action="{{ route('recruiter.offers.close', $offer) }}">
                                @csrf
                                <button class="rounded-xl px-3 py-2 bg-red-600 text-white">Clôturer</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{ $offers->links() }}
    </div>
</x-app-layout>
