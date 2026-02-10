<x-guest-layout>
    <div class="max-w-md mx-auto bg-white/80 backdrop-blur border border-slate-200 rounded-2xl p-6 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900">Terminer votre inscription</h1>
        <p class="text-sm text-slate-600 mt-1">Choisissez votre rôle pour continuer.</p>

        <form method="POST" action="{{ route('onboarding.role.store') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label for="role" class="block text-sm font-medium text-slate-700">Rôle</label>
                <select id="role" name="role" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="" disabled selected>-- Choisir --</option>
                    <option value="employee" @selected(old('role')==='employee')>Employee (Candidat)</option>
                    <option value="recruiter" @selected(old('role')==='recruiter')>Recruiter (Entreprise)</option>
                </select>
                @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-slate-700">Localisation (optionnel)</label>
                <input id="location" name="location" value="{{ old('location') }}" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('location') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="employeeFields" class="hidden space-y-4">
                <div>
                    <label for="speciality" class="block text-sm font-medium text-slate-700">Spécialité</label>
                    <input id="speciality" name="speciality" value="{{ old('speciality') }}" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('speciality') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div id="recruiterFields" class="hidden space-y-4">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-slate-700">Nom de l’entreprise</label>
                    <input id="company_name" name="company_name" value="{{ old('company_name') }}" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('company_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-slate-700">Site web (optionnel)</label>
                    <input id="website" name="website" value="{{ old('website') }}" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('website') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-700">
                Continuer
            </button>
        </form>
    </div>

    <script>
        (function () {
            const role = document.getElementById('role');
            const employee = document.getElementById('employeeFields');
            const recruiter = document.getElementById('recruiterFields');

            function toggle() {
                const v = role.value;
                employee.classList.toggle('hidden', v !== 'employee');
                recruiter.classList.toggle('hidden', v !== 'recruiter');
            }
            role.addEventListener('change', toggle);
            toggle();
        })();
    </script>
</x-guest-layout>
