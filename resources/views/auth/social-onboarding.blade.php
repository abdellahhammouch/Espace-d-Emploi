<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Complete Your Profile</title>

    {{-- Tailwind CDN + forms (comme ton template) --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
</head>

<body class="font-display bg-background-light dark:bg-background-dark min-h-screen flex flex-col items-center justify-center p-6 text-slate-800 dark:text-slate-200">

{{-- Header --}}
<div class="mb-8 text-center">
    <div class="flex items-center justify-center mb-4">
        <div class="bg-primary p-2 rounded-lg">
            <svg class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14h-2v-2h2v2zm0-4h-2V6h2v6z"/>
            </svg>
        </div>
        <span class="ml-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">TalentBridge</span>
    </div>

    <div class="flex items-center justify-center space-x-2">
        <span class="text-xs font-semibold uppercase tracking-widest text-primary bg-primary/10 px-3 py-1 rounded-full">Step 1 of 2</span>
    </div>
</div>

<main class="max-w-4xl w-full">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold mb-3 text-slate-900 dark:text-white">Welcome back!</h1>
        <p class="text-lg text-slate-600 dark:text-slate-400">Please complete your profile to continue.</p>
    </div>

    <form method="POST" action="{{ route('onboarding.role.store') }}" class="space-y-8" id="onboarding-form">
        @csrf

        {{-- Role cards --}}
        <div class="grid md:grid-cols-2 gap-6">
            {{-- Employee / Job seeker --}}
            <label class="relative cursor-pointer group">
                <input
                    class="peer sr-only"
                    id="role-employee"
                    name="role"
                    type="radio"
                    value="employee"
                    @checked(old('role') === 'employee')
                />

                <div class="flex flex-col items-center text-center p-8 bg-white dark:bg-slate-800 rounded-xl border-2 border-transparent transition-all duration-300 shadow-xl shadow-slate-200/50 dark:shadow-none hover:border-primary/50 peer-checked:border-primary peer-checked:bg-primary/[0.02] dark:peer-checked:bg-primary/10">
                    <div class="w-16 h-16 mb-4 rounded-full bg-primary/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 peer-checked:bg-primary">
                        {{-- search icon --}}
                        <svg class="h-8 w-8 text-primary peer-checked:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 21l-4.35-4.35"/>
                            <circle cx="10.5" cy="10.5" r="6.5"/>
                        </svg>
                    </div>

                    <h2 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">I am a Job Seeker</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        Find career opportunities and connect with top companies.
                    </p>

                    <div class="mt-4 flex items-center text-primary text-sm font-semibold opacity-0 peer-checked:opacity-100 transition-opacity">
                        Selected
                        <svg class="h-4 w-4 ml-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 14l-4-4 1.4-1.4L11 12.2l5.6-5.6L18 8l-7 8z"/>
                        </svg>
                    </div>
                </div>
            </label>

            {{-- Recruiter --}}
            <label class="relative cursor-pointer group">
                <input
                    class="peer sr-only"
                    id="role-recruiter"
                    name="role"
                    type="radio"
                    value="recruiter"
                    @checked(old('role') === 'recruiter')
                />

                <div class="flex flex-col items-center text-center p-8 bg-white dark:bg-slate-800 rounded-xl border-2 border-transparent transition-all duration-300 shadow-xl shadow-slate-200/50 dark:shadow-none hover:border-primary/50 peer-checked:border-primary peer-checked:bg-primary/[0.02] dark:peer-checked:bg-primary/10">
                    <div class="w-16 h-16 mb-4 rounded-full bg-primary/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 peer-checked:bg-primary">
                        {{-- briefcase icon --}}
                        <svg class="h-8 w-8 text-primary peer-checked:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10 6h4a2 2 0 012 2v1H8V8a2 2 0 012-2z"/>
                            <path d="M4 9h16v9a2 2 0 01-2 2H6a2 2 0 01-2-2V9z"/>
                            <path d="M10 13h4"/>
                        </svg>
                    </div>

                    <h2 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">I am a Recruiter</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        Post positions and manage applications to find the best talent.
                    </p>

                    <div class="mt-4 flex items-center text-primary text-sm font-semibold opacity-0 peer-checked:opacity-100 transition-opacity">
                        Selected
                        <svg class="h-4 w-4 ml-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 14l-4-4 1.4-1.4L11 12.2l5.6-5.6L18 8l-7 8z"/>
                        </svg>
                    </div>
                </div>
            </label>
        </div>

        {{-- Role error --}}
        @error('role')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        {{-- Employee fields --}}
        <div
            id="employee-fields"
            class="hidden bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 animate-in"
        >
            <h3 class="text-lg font-semibold mb-6 flex items-center text-slate-900 dark:text-white">
                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center mr-3 text-sm">2</span>
                Professional Details
            </h3>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Location</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            name="location"
                            value="{{ old('location') }}"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-primary focus:border-primary text-slate-900 dark:text-white transition-all"
                            placeholder="e.g. Casablanca"
                            type="text"
                        />
                    </div>
                    @error('location') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Speciality</label>
                    <div class="relative">
                        <i class="fa-solid fa-brain absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            name="speciality"
                            value="{{ old('speciality') }}"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-primary focus:border-primary text-slate-900 dark:text-white transition-all"
                            placeholder="e.g. Frontend Developer"
                            type="text"
                            required
                        />
                    </div>
                    @error('speciality') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <button class="mt-8 w-full md:w-auto px-8 py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-all shadow-lg shadow-primary/20 flex items-center justify-center" type="submit">
                Complete Profile
                <span class="ml-2">→</span>
            </button>
        </div>

        {{-- Recruiter fields --}}
        <div
            id="recruiter-fields"
            class="hidden bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 animate-in"
        >
            <h3 class="text-lg font-semibold mb-6 flex items-center text-slate-900 dark:text-white">
                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center mr-3 text-sm">2</span>
                Company Information
            </h3>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Company Name</label>
                    <div class="relative">
                        <i class="fa-solid fa-building absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            name="company_name"
                            value="{{ old('company_name') }}"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-primary focus:border-primary text-slate-900 dark:text-white transition-all"
                            placeholder="Acme Inc."
                            type="text"
                            required
                        />
                    </div>
                    @error('company_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Location</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            name="location"
                            value="{{ old('location') }}"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-primary focus:border-primary text-slate-900 dark:text-white transition-all"
                            placeholder="e.g. Casablanca"
                            type="text"
                        />
                    </div>
                    @error('location') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Company URL (Optional)</label>
                    <div class="relative">
                        <i class="fa-solid fa-globe absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            name="website"
                            value="{{ old('website') }}"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-primary focus:border-primary text-slate-900 dark:text-white transition-all"
                            placeholder="https://"
                            type="url"
                        />
                    </div>
                    @error('website') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <button class="mt-8 w-full md:w-auto px-8 py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-all shadow-lg shadow-primary/20 flex items-center justify-center" type="submit">
                Finish Setup
                <span class="ml-2">→</span>
            </button>
        </div>
    </form>

    <div class="mt-12 text-center">
        <div class="inline-flex items-center justify-center p-4 bg-primary/5 rounded-lg border border-primary/10 max-w-xl">
            <i class="fa-solid fa-circle-info text-primary mr-3 text-lg"></i>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Don't worry, you can always switch roles later from your profile settings.
            </p>
        </div>
    </div>
</main>

<footer class="mt-12 text-center">
    <p class="text-sm text-slate-500 dark:text-slate-500">
        Signed in as
        <span class="font-medium text-slate-700 dark:text-slate-300">{{ auth()->user()->email }}</span>
    </p>

    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit" class="text-sm text-slate-400 hover:text-primary transition-colors duration-200 flex items-center justify-center mx-auto group">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>
            <span>Not you? Sign out</span>
        </button>
    </form>
</footer>

{{-- Background glow --}}
<div class="fixed top-0 left-0 -z-10 w-full h-full overflow-hidden pointer-events-none opacity-20">
    <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-primary/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[30%] h-[30%] bg-primary/5 blur-[100px] rounded-full"></div>
</div>

<style>
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: slideInUp 0.4s ease-out forwards; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const roleEmployee  = document.getElementById('role-employee');
        const roleRecruiter = document.getElementById('role-recruiter');

        const employeeFields  = document.getElementById('employee-fields');
        const recruiterFields = document.getElementById('recruiter-fields');

        const setDisabled = (container, disabled) => {
            container.querySelectorAll('input, select, textarea').forEach((el) => {
                el.disabled = disabled;
            });
        };

        const sync = () => {
            if (roleEmployee.checked) {
                employeeFields.classList.remove('hidden');
                recruiterFields.classList.add('hidden');
                setDisabled(employeeFields, false);
                setDisabled(recruiterFields, true);
            } else if (roleRecruiter.checked) {
                recruiterFields.classList.remove('hidden');
                employeeFields.classList.add('hidden');
                setDisabled(recruiterFields, false);
                setDisabled(employeeFields, true);
            } else {
                employeeFields.classList.add('hidden');
                recruiterFields.classList.add('hidden');
                setDisabled(employeeFields, true);
                setDisabled(recruiterFields, true);
            }
        };

        roleEmployee.addEventListener('change', sync);
        roleRecruiter.addEventListener('change', sync);
        sync(); // initial
    });
</script>

</body>
</html>
