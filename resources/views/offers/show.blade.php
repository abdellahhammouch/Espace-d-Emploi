<x-app-layout>
    <x-slot name="header">
        Détail de l’offre
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <img class="w-full h-64 object-cover" src="{{ asset('storage/'.$offer->image_path) }}" alt="">
            <div class="p-6 space-y-2">
                <h1 class="text-2xl font-extrabold text-slate-900">{{ $offer->title }}</h1>
                <p class="text-slate-500">
                    {{ optional($offer->recruiter->recruiterProfile)->company_name ?? 'Entreprise' }} • {{ $offer->place }}
                    • {{ $offer->contractType->name ?? '' }}
                </p>
                <div class="pt-3 text-slate-700 whitespace-pre-line">{{ $offer->description }}</div>

                @if($offer->is_closed)
                    <div class="mt-4 inline-flex px-3 py-2 rounded-xl bg-red-50 text-red-700 text-sm">
                        Offre clôturée
                    </div>
                @endif
            </div>
        </div>

        @if(auth()->user()->hasRole('employee') && !$offer->is_closed)
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                @if($applied)
                    <div class="text-green-700 font-semibold">✅ Tu as déjà postulé à cette offre.</div>
                @else
                    <form method="POST" action="{{ route('offers.apply', $offer) }}" class="space-y-3">
                        @csrf
                        <textarea name="note" class="w-full rounded-xl border-slate-200" rows="4" placeholder="Message optionnel..."></textarea>
                        <button class="rounded-xl px-5 py-2 bg-slate-900 text-white">Postuler</button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
