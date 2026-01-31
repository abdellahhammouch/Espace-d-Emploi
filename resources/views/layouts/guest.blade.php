<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{ $title ?? 'Sign In' }} | {{ config('app.name', 'RecruitSmart') }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "emerald-accent": "#10b981",
                        "navy-deep": "#0f172a",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
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

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
    </style>

    @stack('head')
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-200 min-h-screen flex flex-col">

<header class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 flex h-16 items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="size-8 bg-primary rounded flex items-center justify-center text-white">
                <span class="material-symbols-outlined">hub</span>
            </div>
            <h2 class="text-xl font-black tracking-tight text-navy-deep dark:text-white">
                {{ config('app.name', 'RecruitSmart') }}
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <a class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-primary transition-colors px-4 py-2"
               href="{{ url('/') }}">
                Back to Site
            </a>
        </div>
    </div>
</header>

<main class="flex-grow flex items-center justify-center px-6 py-12 relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(45%_45%_at_50%_50%,rgba(19,91,236,0.03)_0%,rgba(255,255,255,0)_100%)]"></div>
    <div class="absolute -top-24 -right-24 size-96 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 size-96 bg-emerald-accent/5 rounded-full blur-3xl"></div>

    {{ $slot }}
</main>

<footer class="py-8 bg-white dark:bg-background-dark border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <p class="text-xs text-slate-500">© {{ now()->year }} {{ config('app.name', 'RecruitSmart') }}. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
