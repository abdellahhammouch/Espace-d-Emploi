<x-app-layout>
    <x-slot name="header">Modifier l’offre</x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <form method="POST" action="{{ route('recruiter.offers.update', $offer) }}" enctype="multipart/form-data"
              class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-sm text-slate-600">Type contrat</label>
                <select name="contract_type_id" class="w-full rounded-xl border-slate-200">
                    @foreach($contractTypes as $ct)
                        <option value="{{ $ct->id }}" @selected($offer->contract_type_id == $ct->id)>{{ $ct->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-slate-600">Titre</label>
                <input name="title" value="{{ $offer->title }}" class="w-full rounded-xl border-slate-200" required />
            </div>

            <div>
                <label class="text-sm text-slate-600">Lieu</label>
                <input name="place" value="{{ $offer->place }}" class="w-full rounded-xl border-slate-200" required />
            </div>

            <div>
                <label class="text-sm text-slate-600">Date début</label>
                <input type="date" name="start_date" value="{{ optional($offer->start_date)->format('Y-m-d') }}" class="w-full rounded-xl border-slate-200" />
            </div>

            <div>
                <label class="text-sm text-slate-600">Nouvelle image (optionnel)</label>
                <input type="file" name="image" class="w-full" />
                <p class="text-xs text-slate-500 mt-1">Si tu ne choisis rien, on garde l’image actuelle.</p>
            </div>

            <div>
                <label class="text-sm text-slate-600">Description</label>
                <textarea name="description" rows="6" class="w-full rounded-xl border-slate-200" required>{{ $offer->description }}</textarea>
            </div>

            <button class="rounded-xl px-5 py-2 bg-slate-900 text-white">Mettre à jour</button>
        </form>
    </div>
</x-app-layout>
