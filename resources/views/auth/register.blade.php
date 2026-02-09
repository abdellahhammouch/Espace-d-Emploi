<x-guest-layout>
    @php($title = 'Sign UP')
    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900 rounded-2xl shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-800 p-8 lg:p-10">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-navy-deep dark:text-white mb-2">Create Account</h1>
            <p class="text-slate-500 dark:text-slate-400">Join thousands of professionals and top companies today.</p>
        </div>

        {{-- Messages / erreurs Laravel --}}
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Toggle (UI) : Recruiter / Job Seeker --}}
        <div class="p-1 toggle-bg rounded-xl flex mb-8" id="typeToggle">
            <button type="button"
                    data-value="recruiter"
                    class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all bg-white dark:bg-slate-800 text-primary shadow-sm">
                I am a Recruiter
            </button>
            <button type="button"
                    data-value="employee"
                    class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200">
                I am a Job Seeker
            </button>
        </div>

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
            @csrf

            {{-- IMPORTANT: si tu veux ENREGISTRER ce champ, il faut l’ajouter côté validation + DB --}}
            <input type="hidden" name="role" id="role" value="recruiter"/>
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Full Name</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person</span>
                    <input
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="John Doe"
                        required
                        type="text"
                        autocomplete="name"
                    />
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Professional Email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                    <input
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="name@company.com"
                        required
                        type="email"
                        autocomplete="username"
                    />
                </div>
            </div>
            <div class="mt-4">
                <x-input-label for="location" value="Location" />
                <x-text-input id="location" class="block mt-1 w-full"
                    type="text" name="location" value="{{ old('location') }}"
                    placeholder="Casablanca, Safi..." />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>
            {{-- Speciality (only for employee/job seeker) --}}
            <div id="employeeFields" class="flex flex-col gap-1.5 hidden">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Speciality</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">work</span>
                    <input
                        id="speciality"
                        name="speciality"
                        value="{{ old('speciality') }}"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="Ex: Laravel, Comptabilité, Marketing..."
                        type="text"
                        autocomplete="organization-title"
                    />
                </div>

                {{-- si tu veux afficher l’erreur de validation de ce champ --}}
                <x-input-error :messages="$errors->get('speciality')" class="mt-2" />
            </div>
            {{-- Company Name (only for recruiter) --}}
            <div id="recruiterFields" class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Company Name</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">business</span>
                    <input
                        id="company_name"
                        name="company_name"
                        value="{{ old('company_name') }}"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="Ex: Google, OCP, Capgemini..."
                        type="text"
                        autocomplete="organization"
                    />
                </div>

                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                    <input
                        id="password"
                        name="password"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl h-12 pl-12 pr-12 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="••••••••"
                        required
                        type="password"
                        autocomplete="new-password"
                    />
                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                            type="button"
                            id="togglePassword">
                        <span class="material-symbols-outlined text-xl">visibility</span>
                    </button>
                </div>
            </div>

            {{-- Breeze nécessite souvent password_confirmation --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Confirm Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                    <input
                        name="password_confirmation"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="••••••••"
                        required
                        type="password"
                        autocomplete="new-password"
                    />
                </div>
            </div>

            <div class="flex items-start gap-3 mt-1">
                <input class="mt-1 rounded border-slate-300 text-primary focus:ring-primary" id="terms" required type="checkbox"/>
                <label class="text-xs text-slate-500 leading-normal" for="terms">
                    By creating an account, you agree to our
                    <a class="text-primary hover:underline font-semibold" href="#">Terms of Service</a>
                    and
                    <a class="text-primary hover:underline font-semibold" href="#">Privacy Policy</a>.
                </label>
            </div>

            <button class="bg-primary text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-primary/25 active:scale-[0.98] mt-2" type="submit">
                Create Account
            </button>
        </form>
    </div>

    <script>
        // Toggle Recruiter / Job Seeker (UI)
        (function () {
            const wrap = document.getElementById('typeToggle');
            if (!wrap) return;

            const hidden = document.getElementById('role');
            const recruiterFields = document.getElementById('recruiterFields');
            const companyInput = document.getElementById('company_name');
            const buttons = wrap.querySelectorAll('button[data-value]');

            function setActive(value) {
                hidden.value = value;
                const employeeFields = document.getElementById('employeeFields');
                const specialityInput = document.getElementById('speciality');
                const isRecruiter = (value === 'recruiter');

                if (recruiterFields) recruiterFields.classList.toggle('hidden', !isRecruiter);
                if (companyInput) companyInput.required = isRecruiter;

                const isEmployee = (value === 'employee');

                if (employeeFields) employeeFields.classList.toggle('hidden', !isEmployee);

                // rendre "speciality" obligatoire seulement si employee
                if (specialityInput) specialityInput.required = isEmployee;
                buttons.forEach(btn => {
                    const isActive = btn.dataset.value === value;
                    btn.classList.toggle('bg-white', isActive);
                    btn.classList.toggle('dark:bg-slate-800', isActive);
                    btn.classList.toggle('text-primary', isActive);
                    btn.classList.toggle('shadow-sm', isActive);

                    btn.classList.toggle('text-slate-500', !isActive);
                    btn.classList.toggle('dark:text-slate-400', !isActive);
                });
            }

            buttons.forEach(btn => btn.addEventListener('click', () => setActive(btn.dataset.value)));
            setActive(hidden.value || 'recruiter');
        })();

        // Show/Hide password
        (function () {
            const btn = document.getElementById('togglePassword');
            const input = document.getElementById('password');
            if (!btn || !input) return;

            btn.addEventListener('click', () => {
                input.type = (input.type === 'password') ? 'text' : 'password';
            });
        })();
    </script>
</x-guest-signup-layout>
