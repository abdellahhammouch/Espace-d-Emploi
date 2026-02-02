@php
    $user = auth()->user();

    // Avatar : storage si tu as avatar_path sinon un avatar généré
    $avatarUrl = $user->avatar_path
        ? \Illuminate\Support\Facades\Storage::url($user->avatar_path)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=137fec&color=ffffff&bold=true';

    // Company name (optionnel) — si plus tard tu crées une relation $user->recruiterProfile
    $companyName = $user->company_name ?? null; // fallback si tu as un champ dans users (sinon laisse null)
@endphp

<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Recruiter Dashboard</title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: { display: ["Inter", "sans-serif"] },
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
                <a class="text-primary text-sm font-semibold leading-normal" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">My Jobs</a>
                <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">Applications</a>
                <a class="text-[#111418] dark:text-gray-300 text-sm font-medium hover:text-primary transition-colors" href="#">Messages</a>
            </nav>

            <div class="flex items-center gap-3 border-l border-gray-200 dark:border-gray-700 pl-6">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-[#111418] dark:text-white">{{ $user->name }}</p>
                    <p class="text-[10px] text-gray-500">Recruiter</p>
                </div>

                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-primary/20"
                     style="background-image: url('{{ $avatarUrl }}');">
                </div>

                <!-- Logout -->
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

    <!-- Header -->
    <div class="pt-10 pb-6 px-4">
        <div class="bg-white dark:bg-[#1a242f] border border-gray-100 dark:border-gray-800 rounded-2xl p-6 md:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-[28px] font-extrabold tracking-tight text-[#111418] dark:text-white">
                        Recruiter Dashboard
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">
                        Manage job offers and review candidates easily.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Plus tard: route('offers.create') --}}
                    <a href="#"
                       class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-5 rounded-xl transition-all shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Create Job Offer
                    </a>
                    <a href="#"
                       class="inline-flex items-center justify-center gap-2 bg-white dark:bg-[#101922] border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-200 font-semibold py-3 px-5 rounded-xl hover:border-primary/40 transition-all">
                        <span class="material-symbols-outlined text-[20px]">folder</span>
                        View My Offers
                    </a>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light/40 dark:bg-background-dark/40 p-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Open Offers</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#111418] dark:text-white">0</p>
                </div>
                <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light/40 dark:bg-background-dark/40 p-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Applications Received</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#111418] dark:text-white">0</p>
                </div>
                <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light/40 dark:bg-background-dark/40 p-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Closed Offers</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#111418] dark:text-white">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Offers -->
        <section class="lg:col-span-2 bg-white dark:bg-[#1a242f] rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="p-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
                <h2 class="font-bold text-[#111418] dark:text-white">Recent Job Offers</h2>
                <a href="#" class="text-sm font-semibold text-primary hover:underline">See all</a>
            </div>

            <div class="p-5 space-y-4">
                {{-- Placeholder statique pour test --}}
                <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-800 flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-[#111418] dark:text-white">No offers yet</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Create your first job offer to start receiving applications.
                        </p>
                    </div>
                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                        Empty
                    </span>
                </div>
            </div>
        </section>

        <!-- Applications Inbox -->
        <aside class="bg-white dark:bg-[#1a242f] rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 dark:border-gray-800">
                <h2 class="font-bold text-[#111418] dark:text-white">Latest Applications</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Review candidates quickly.</p>
            </div>

            <div class="p-5 space-y-4">
                {{-- Placeholder statique pour test --}}
                <div class="rounded-xl border border-gray-100 dark:border-gray-800 p-4">
                    <p class="text-sm font-bold text-[#111418] dark:text-white">No applications yet</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        When candidates apply, you’ll see them here.
                    </p>
                </div>
            </div>
        </aside>

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
