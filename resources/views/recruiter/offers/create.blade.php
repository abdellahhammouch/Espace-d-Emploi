<x-app-layout>
    <x-slot name="header">Créer une offre</x-slot>

    <div class="max-w-3xl mx-auto p-6">
        <form method="POST" action="{{ route('recruiter.offers.store') }}" enctype="multipart/form-data"
              class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
            @csrf

            <div>
                <label class="text-sm text-slate-600">Type contrat</label>
                <select name="contract_type_id" class="w-full rounded-xl border-slate-200">
                    @foreach($contractTypes as $ct)
                        <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-slate-600">Titre</label>
                <input name="title" class="w-full rounded-xl border-slate-200" required />
            </div>

            <div>
                <label class="text-sm text-slate-600">Lieu</label>
                <input name="place" class="w-full rounded-xl border-slate-200" required />
            </div>

            <div>
                <label class="text-sm text-slate-600">Date début</label>
                <input type="date" name="start_date" class="w-full rounded-xl border-slate-200" />
            </div>

            <div>
                <label class="text-sm text-slate-600">Image (obligatoire)</label>
                <input type="file" name="image" class="w-full" required />
            </div>

            <div>
                <label class="text-sm text-slate-600">Description</label>
                <textarea name="description" rows="6" class="w-full rounded-xl border-slate-200" required></textarea>
            </div>

            <button class="rounded-xl px-5 py-2 bg-slate-900 text-white">Enregistrer</button>
        </form>
    </div>
</x-app-layout>
