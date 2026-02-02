@php
    $user = auth()->user();

    // Avatar : si tu as avatar_path en storage, sinon un avatar par défaut
    $avatarUrl = $user->avatar_path
        ? \Illuminate\Support\Facades\Storage::url($user->avatar_path)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=137fec&color=ffffff&bold=true';
@endphp

<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Job Board Dashboard</title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

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
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white transition-colors duration-200">

<!-- Top Navigation Bar -->
<div class="w-full bg-white dark:bg-[#1a242f] border-b border-[#f0f2f4] dark:border-[#2d3748] sticky top-0 z-50">
    <div class="max-w-[1200px] mx-auto px-4 md:px-10 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4 text-primary">
            <div class="size-8">
                <svg fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z"></path>
                </svg>
            </div>
            <h2 class="text-[#111418] dark:text-white text-xl font-bold leading-tight tracking-tight">HireFlow</h2>
        </div>

        <div class="flex flex-1 justify-end items-center gap-8">
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-primary text-sm font-semibold leading-normal" href="#">Dashboard</a>
                <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">Applications</a>
                <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">Messages</a>
                <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">Job Alerts</a>
            </nav>

            <div class="flex items-center gap-3 border-l border-gray-200 dark:border-gray-700 pl-6">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-[#111418] dark:text-white">{{ $user->name }}</p>
                    <p class="text-[10px] text-gray-500">Employee</p>
                </div>

                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-primary/20"
                     style="background-image: url('{{ $avatarUrl }}');">
                </div>

                <!-- Logout (important pour tester login/register facilement) -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="ml-2 text-xs font-semibold text-gray-500 hover:text-primary transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<main class="max-w-[1200px] mx-auto pb-20">

    <!-- Headline -->
    <div class="pt-10 pb-4">
        <h1 class="text-[#111418] dark:text-white tracking-tight text-[32px] font-extrabold leading-tight px-4 text-center">
            Discover your next career move
        </h1>
        <p class="text-center text-gray-500 dark:text-gray-400 mt-2">Explore 1,200+ new opportunities across the globe</p>
    </div>

    <!-- Search Bar -->
    <div class="px-4 py-6 max-w-[800px] mx-auto">
        <div class="bg-white dark:bg-[#1a242f] p-2 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-2">
            <div class="flex-1 flex items-center px-4">
                <span class="material-symbols-outlined text-gray-400">search</span>
                <input class="w-full border-none bg-transparent focus:ring-0 text-[#111418] dark:text-white placeholder:text-gray-400 text-base py-3 px-2"
                       placeholder="Job title, keywords, or company..."
                       value=""/>
            </div>
            <div class="hidden sm:flex items-center px-4 border-l border-gray-200 dark:border-gray-700">
                <span class="material-symbols-outlined text-gray-400">location_on</span>
                <input class="w-32 border-none bg-transparent focus:ring-0 text-[#111418] dark:text-white placeholder:text-gray-400 text-base py-3 px-2"
                       placeholder="Remote"
                       value=""/>
            </div>
            <button class="bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-8 rounded-lg transition-all">
                Search
            </button>
        </div>
    </div>

    <!-- Filter Chips -->
    <div class="px-4 mb-8">
        <div class="flex gap-3 justify-center flex-wrap">
            <div class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary text-white px-5 cursor-pointer">
                <p class="text-sm font-semibold">All Jobs</p>
            </div>
            <div class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white dark:bg-[#1a242f] border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 px-5 cursor-pointer hover:border-primary transition-colors">
                <p class="text-sm font-medium">CDI (Full-time)</p>
            </div>
            <div class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white dark:bg-[#1a242f] border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 px-5 cursor-pointer hover:border-primary transition-colors">
                <p class="text-sm font-medium">Freelance</p>
            </div>
            <div class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white dark:bg-[#1a242f] border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 px-5 cursor-pointer hover:border-primary transition-colors">
                <p class="text-sm font-medium">Remote Only</p>
            </div>
            <div class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white dark:bg-[#1a242f] border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 px-5 cursor-pointer hover:border-primary transition-colors">
                <p class="text-sm font-medium">Internship</p>
            </div>
        </div>
    </div>

    <!-- Job Grid -->
    <div class="px-4">
        {!!--
            Ici, ton HTML est très long.
            Pour l’instant on le laisse “statique” pour tester.
            Après, on le rend dynamique avec DB + Livewire.
        --!!}

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Colle ici le reste de tes Job Cards tel quel (aucune modif obligatoire) -->
            {!!--
                Tu peux recoller toutes tes cards ici sans changer.
                Le but maintenant : tester la redirection + affichage.
            --!!}
        </div>

        <!-- Loading Indicator -->
        <div class="mt-12 flex flex-col items-center justify-center gap-4">
            <div class="size-8 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fetching more dream jobs...</p>
        </div>
    </div>
</main>

<footer class="bg-white dark:bg-[#1a242f] py-10 border-t border-[#f0f2f4] dark:border-[#2d3748]">
    <div class="max-w-[1200px] mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-2 text-primary opacity-60 grayscale">
            <div class="size-6">
                <svg fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z"></path>
                </svg>
            </div>
            <span class="font-bold text-sm">HireFlow © 2024</span>
        </div>
        <div class="flex gap-8">
            <a class="text-xs text-gray-500 hover:text-primary" href="#">Privacy Policy</a>
            <a class="text-xs text-gray-500 hover:text-primary" href="#">Terms of Service</a>
            <a class="text-xs text-gray-500 hover:text-primary" href="#">Help Center</a>
        </div>
    </div>
</footer>

</body>
</html>
