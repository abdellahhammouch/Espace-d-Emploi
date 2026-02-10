<x-guest-layout>
    @php($title = 'Sign In')

    <div class="w-full max-w-[440px]">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-800 p-8 lg:p-10">

            <div class="flex flex-col gap-2 mb-8">
                <h1 class="text-3xl font-black text-navy-deep dark:text-white tracking-tight">Welcome back</h1>
                <p class="text-slate-500 dark:text-slate-400">Please enter your details to sign in.</p>
            </div>

            {{-- Status message (ex: reset password link sent) --}}
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Global errors --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                @csrf

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Professional Email</label>
                    <input
                        name="email"
                        value="{{ old('email') }}"
                        class="bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg h-12 px-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="name@company.com"
                        required
                        autofocus
                        type="email"
                        autocomplete="username"
                    />
                </div>

                <div class="flex flex-col gap-1.5 relative">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>

                        @if (Route::has('password.request'))
                            <a class="text-xs text-primary font-bold hover:underline" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <input
                        name="password"
                        class="bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg h-12 px-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                        placeholder="••••••••"
                        required
                        type="password"
                        autocomplete="current-password"
                    />
                </div>
                <button class="bg-primary text-white font-bold h-12 rounded-lg hover:bg-blue-700 transition-all shadow-lg shadow-primary/20 active:scale-[0.98] mt-2" type="submit">
                    Sign In
                </button>
            </form>
            <div class="space-y-3">
                {{-- Google --}}
                <a href="{{ route('social.redirect', ['provider' => 'google']) }}"
                   class="w-full relative flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="absolute left-4 inline-flex items-center justify-center">
                        <img src="{{ asset('icons/google.svg') }}" alt="Google" class="h-5 w-5">
                    </span>
                    <span>Continue with Google</span>
                </a>

                {{-- Facebook --}}
                <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}"
                   class="w-full relative flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="absolute left-4 inline-flex items-center justify-center">
                        {{-- Option 1: image depuis /public/icons/facebook.svg --}}
                        <img src="{{ asset('icons/facebook.svg') }}" alt="Facebook" class="h-5 w-5">
                    </span>
                    <span>Continue with Facebook</span>
                </a>
            </div>
            <div class="mt-10 pt-8 border-t border-slate-100 dark:border-slate-800 text-center">
                <p class="text-sm text-slate-500">
                    Don't have an account?
                    <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Create an account</a>
                </p>
            </div>
        </div>

        <div class="mt-8 flex justify-center gap-6">
            <a class="text-xs font-medium text-slate-400 hover:text-slate-600 transition-colors" href="#">Privacy Policy</a>
            <a class="text-xs font-medium text-slate-400 hover:text-slate-600 transition-colors" href="#">Terms of Service</a>
            <a class="text-xs font-medium text-slate-400 hover:text-slate-600 transition-colors" href="#">Help Center</a>
        </div>
    </div>
</x-guest-layout>
