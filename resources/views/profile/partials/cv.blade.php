@php
    $profile = $user->employeeProfile;
    $experiences = $profile?->experiences ?? collect();
    $educations  = $profile?->educations  ?? collect();
@endphp

<div class="space-y-8">

    {{-- EXPERIENCES --}}
    <section class="bg-white rounded-xl border border-[#f0f2f4] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#f0f2f4] flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-[#111418]">Expériences</h2>

            {{-- + Add --}}
            <button type="button"
                class="size-9 rounded-full bg-[#137fec]/10 text-[#137fec] flex items-center justify-center hover:bg-[#137fec]/15 transition"
                onclick="document.getElementById('exp-create').classList.toggle('hidden')">
                <span class="material-symbols-outlined text-[20px]">add</span>
            </button>
        </div>

        {{-- Create form (hidden by default) --}}
        <div id="exp-create" class="hidden px-6 py-5 border-b border-[#f0f2f4] bg-[#f6f7f8]">
            <form method="POST" action="{{ route('experiences.store') }}" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input name="job_title" class="rounded-lg border border-[#e7ecef] p-3" placeholder="Poste (ex: Développeur Laravel)" required>
                <input name="company" class="rounded-lg border border-[#e7ecef] p-3" placeholder="Entreprise" required>
                <input name="employment_type" class="rounded-lg border border-[#e7ecef] p-3" placeholder="Type (CDI, CDD, Stage...)">
                <div class="flex gap-3">
                    <input type="date" name="start_date" class="w-full rounded-lg border border-[#e7ecef] p-3">
                    <input type="date" name="end_date" class="w-full rounded-lg border border-[#e7ecef] p-3">
                </div>

                <label class="flex items-center gap-2 text-sm text-[#617589] md:col-span-2">
                    <input type="checkbox" name="is_current" value="1" class="rounded border-[#cbd5e1] text-[#137fec] focus:ring-[#137fec]">
                    Poste actuel
                </label>

                <textarea name="description" rows="3" class="md:col-span-2 rounded-lg border border-[#e7ecef] p-3" placeholder="Description..."></textarea>

                <div class="md:col-span-2 flex justify-end gap-3">
                    <button type="button"
                        class="px-4 py-2 rounded-lg border border-[#e7ecef] text-[#617589]"
                        onclick="document.getElementById('exp-create').classList.add('hidden')">
                        Annuler
                    </button>
                    <button class="px-5 py-2 rounded-lg bg-[#137fec] text-white font-bold hover:opacity-90">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>

        {{-- List --}}
        <div class="divide-y divide-[#f0f2f4]">
            @forelse($experiences as $exp)
                <div class="px-6 py-5" x-data="{ edit:false }">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="font-bold text-[#111418]">{{ $exp->job_title }}</div>
                            <div class="text-sm text-[#617589]">{{ $exp->company }}</div>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- Pencil --}}
                            <button type="button" @click="edit = !edit"
                                class="size-9 rounded-full bg-[#137fec]/10 text-[#137fec] flex items-center justify-center hover:bg-[#137fec]/15 transition">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>

                            {{-- Trash --}}
                            <form method="POST" action="{{ route('experiences.destroy', $exp) }}">
                                @csrf @method('DELETE')
                                <button class="size-9 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Edit form --}}
                    <form x-show="edit" x-cloak method="POST" action="{{ route('experiences.update', $exp) }}"
                          class="mt-4 grid md:grid-cols-2 gap-4">
                        @csrf @method('PATCH')

                        <input name="job_title" value="{{ $exp->job_title }}" class="rounded-lg border border-[#e7ecef] p-3" required>
                        <input name="company" value="{{ $exp->company }}" class="rounded-lg border border-[#e7ecef] p-3" required>
                        <input name="employment_type" value="{{ $exp->employment_type }}" class="rounded-lg border border-[#e7ecef] p-3" placeholder="Type">
                        <div class="flex gap-3">
                            <input type="date" name="start_date" value="{{ optional($exp->start_date)->format('Y-m-d') }}" class="w-full rounded-lg border border-[#e7ecef] p-3">
                            <input type="date" name="end_date" value="{{ optional($exp->end_date)->format('Y-m-d') }}" class="w-full rounded-lg border border-[#e7ecef] p-3">
                        </div>

                        <label class="flex items-center gap-2 text-sm text-[#617589] md:col-span-2">
                            <input type="checkbox" name="is_current" value="1" class="rounded border-[#cbd5e1] text-[#137fec] focus:ring-[#137fec]"
                                   @checked($exp->is_current)>
                            Poste actuel
                        </label>

                        <textarea name="description" rows="3" class="md:col-span-2 rounded-lg border border-[#e7ecef] p-3">{{ $exp->description }}</textarea>

                        <div class="md:col-span-2 flex justify-end gap-3">
                            <button type="button" class="px-4 py-2 rounded-lg border border-[#e7ecef] text-[#617589]" @click="edit=false">Annuler</button>
                            <button class="px-5 py-2 rounded-lg bg-[#137fec] text-white font-bold hover:opacity-90">Enregistrer</button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="px-6 py-8 text-sm text-[#617589]">Aucune expérience pour le moment.</div>
            @endforelse
        </div>
    </section>

    {{-- FORMATIONS (même principe) --}}
    <section class="bg-white rounded-xl border border-[#f0f2f4] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#f0f2f4] flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-[#111418]">Formations</h2>

            <button type="button"
                class="size-9 rounded-full bg-[#137fec]/10 text-[#137fec] flex items-center justify-center hover:bg-[#137fec]/15 transition"
                onclick="document.getElementById('edu-create').classList.toggle('hidden')">
                <span class="material-symbols-outlined text-[20px]">add</span>
            </button>
        </div>

        <div id="edu-create" class="hidden px-6 py-5 border-b border-[#f0f2f4] bg-[#f6f7f8]">
            <form method="POST" action="{{ route('educations.store') }}" class="grid md:grid-cols-2 gap-4">
                @csrf
                <input name="degree" class="rounded-lg border border-[#e7ecef] p-3" placeholder="Diplôme" required>
                <input name="school" class="rounded-lg border border-[#e7ecef] p-3" placeholder="École" required>
                <input name="field" class="rounded-lg border border-[#e7ecef] p-3" placeholder="Spécialité (optionnel)">
                <div class="flex gap-3">
                    <input type="number" name="start_year" class="w-full rounded-lg border border-[#e7ecef] p-3" placeholder="Début (année)">
                    <input type="number" name="end_year" class="w-full rounded-lg border border-[#e7ecef] p-3" placeholder="Fin (année)">
                </div>

                <div class="md:col-span-2 flex justify-end gap-3">
                    <button type="button"
                        class="px-4 py-2 rounded-lg border border-[#e7ecef] text-[#617589]"
                        onclick="document.getElementById('edu-create').classList.add('hidden')">
                        Annuler
                    </button>
                    <button class="px-5 py-2 rounded-lg bg-[#137fec] text-white font-bold hover:opacity-90">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>

        <div class="divide-y divide-[#f0f2f4]">
            @forelse($educations as $edu)
                <div class="px-6 py-5" x-data="{ edit:false }">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="font-bold text-[#111418]">{{ $edu->degree }}</div>
                            <div class="text-sm text-[#617589]">{{ $edu->school }}</div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="edit = !edit"
                                class="size-9 rounded-full bg-[#137fec]/10 text-[#137fec] flex items-center justify-center hover:bg-[#137fec]/15 transition">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>

                            <form method="POST" action="{{ route('educations.destroy', $edu) }}">
                                @csrf @method('DELETE')
                                <button class="size-9 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <form x-show="edit" x-cloak method="POST" action="{{ route('educations.update', $edu) }}"
                          class="mt-4 grid md:grid-cols-2 gap-4">
                        @csrf @method('PATCH')

                        <input name="degree" value="{{ $edu->degree }}" class="rounded-lg border border-[#e7ecef] p-3" required>
                        <input name="school" value="{{ $edu->school }}" class="rounded-lg border border-[#e7ecef] p-3" required>
                        <input name="field" value="{{ $edu->field }}" class="rounded-lg border border-[#e7ecef] p-3" placeholder="Field">
                        <div class="flex gap-3">
                            <input type="number" name="start_year" value="{{ $edu->start_year }}" class="w-full rounded-lg border border-[#e7ecef] p-3">
                            <input type="number" name="end_year" value="{{ $edu->end_year }}" class="w-full rounded-lg border border-[#e7ecef] p-3">
                        </div>

                        <div class="md:col-span-2 flex justify-end gap-3">
                            <button type="button" class="px-4 py-2 rounded-lg border border-[#e7ecef] text-[#617589]" @click="edit=false">Annuler</button>
                            <button class="px-5 py-2 rounded-lg bg-[#137fec] text-white font-bold hover:opacity-90">Enregistrer</button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="px-6 py-8 text-sm text-[#617589]">Aucune formation pour le moment.</div>
            @endforelse
        </div>
    </section>

</div>
