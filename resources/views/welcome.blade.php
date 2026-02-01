{{-- resources/views/landing.blade.php --}}
@extends('layouts.public')

@section('title', 'LaravelJobConnect - Connect with Top Talent')

@section('content')
    {{-- Page wrapper (full HTML removed because layouts.app already has <html><head><body>) --}}
    <div class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white transition-colors duration-200 min-h-screen">

        {{-- Top Navigation Bar --}}
        <header class="sticky top-0 z-50 w-full bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-[#f0f2f4] dark:border-gray-800">
            <div class="max-w-[1200px] mx-auto px-6 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="text-primary">
                        <svg class="size-8" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z" fill="currentColor" fill-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">LaravelJobConnect</span>
                </div>

                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Find Talent</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Browse Jobs</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Companies</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Pricing</a>
                </nav>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 text-sm font-bold bg-[#f0f2f4] dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-sm font-bold bg-[#f0f2f4] dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            Log In
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-sm font-bold bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="max-w-[1200px] mx-auto px-6 py-12">

            {{-- Hero Section --}}
            <section class="@container mb-12">
                <div class="flex flex-col gap-10 lg:flex-row lg:items-center">
                    <div class="flex-1 space-y-6">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                            The Laravel Professional Network
                        </div>

                        <h1 class="text-5xl lg:text-6xl font-black leading-tight tracking-tight">
                            Connecting Top Talent with <span class="text-primary">Leading Recruiters</span>
                        </h1>

                        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-xl leading-relaxed">
                            The streamlined platform for Laravel professionals and the companies that need them. Find specialized experts in minutes.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <a href="#"
                               class="px-8 py-4 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:-translate-y-0.5 transition-all inline-flex items-center justify-center">
                                Post a Job Opening
                            </a>

                            <a href="#"
                               class="px-8 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-all inline-flex items-center justify-center">
                                View Developer Profiles
                            </a>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="relative rounded-2xl overflow-hidden aspect-video shadow-2xl group">
                            <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-transparent pointer-events-none"></div>
                            <div class="w-full h-full bg-cover bg-center"
                                 style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAPdl_VlcqrVtF5Ntev0ph0YrF8JvKVgLgyz8AzVHHZ5k4gKe-zxqpQBfcKPm3yQxf2XClI5tlauwdNipoSfM6Udcd0JY87A_Z8PcKvYfii-QyUEirgMZHHxFHYpB4ioevsTHEVRpRCijUo_9rmBUbzVf7G_uBWqwCjl4RlmhLXB4ii7fx8xM6sUTDR_Zyj-ZjWXJ-kSYFSpctPbzKonOVxobWArIUAPCbR2So9jKs5S1vcW1i3dCNCFIAQgNuOYuXDlsqrp-fXidfb');">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Search Bar & Filters --}}
            <section class="bg-white dark:bg-background-dark border border-[#f0f2f4] dark:border-gray-800 rounded-2xl p-6 shadow-sm mb-16">
                <form method="GET" action="">
                    <div class="flex flex-col md:flex-row gap-4">

                        <div class="flex-1">
                            <label class="flex items-center h-14 bg-[#f0f2f4] dark:bg-gray-800 rounded-lg px-4 border-2 border-transparent focus-within:border-primary/30 transition-all">
                                <span class="material-symbols-outlined text-gray-400 mr-3">search</span>
                                <input
                                    name="q"
                                    value="{{ request('q') }}"
                                    class="bg-transparent border-none focus:ring-0 w-full text-base font-normal placeholder:text-gray-500"
                                    placeholder="Search by name, skill, or job title..."
                                    type="text"
                                />
                            </label>
                        </div>

                        <div class="flex gap-3 overflow-x-auto pb-1 md:pb-0">
                            <button type="button"
                                    class="flex h-14 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-[#f0f2f4] dark:bg-gray-800 px-5 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <p class="text-sm font-semibold">Backend</p>
                                <span class="material-symbols-outlined text-sm">expand_more</span>
                            </button>

                            <button type="button"
                                    class="flex h-14 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-[#f0f2f4] dark:bg-gray-800 px-5 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <p class="text-sm font-semibold">Location</p>
                                <span class="material-symbols-outlined text-sm">location_on</span>
                            </button>

                            <button type="submit"
                                    class="flex h-14 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-primary text-white px-8 font-bold hover:bg-primary/90 transition-all">
                                Search
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <span class="text-xs font-bold text-gray-400 uppercase">Popular:</span>
                        <div class="flex gap-2">
                            @php
                                $popularTags = ['Livewire', 'Tailwind CSS', 'TALL Stack', 'Microservices'];
                            @endphp

                            @foreach($popularTags as $tag)
                                <a href="#"
                                   class="px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full cursor-pointer hover:bg-primary/20">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </form>
            </section>

            {{-- CTA Registration Cards --}}
            <h2 class="text-2xl font-bold mb-8 px-2">Ready to get started?</h2>

            <div class="grid md:grid-cols-2 gap-8 mb-20">
                {{-- Recruiter Card --}}
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-8 hover:shadow-xl transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="material-symbols-outlined text-[120px]">corporate_fare</span>
                    </div>

                    <div class="flex items-center justify-center size-14 rounded-xl bg-primary text-white mb-6">
                        <span class="material-symbols-outlined text-3xl">search_check</span>
                    </div>

                    <h3 class="text-2xl font-bold mb-4">I am a Recruiter</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        Access our vetted database of over 10,000 Laravel experts. Post job listings and find the perfect match for your engineering team.
                    </p>

                    <a href="{{ route('register') ?? '#' }}"
                       class="w-full py-4 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-colors inline-flex items-center justify-center">
                        Find Top Talent
                    </a>
                </div>

                {{-- Job Seeker Card --}}
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-8 hover:shadow-xl transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="material-symbols-outlined text-[120px]">person_search</span>
                    </div>

                    <div class="flex items-center justify-center size-14 rounded-xl bg-gray-100 dark:bg-gray-800 text-primary mb-6">
                        <span class="material-symbols-outlined text-3xl">work</span>
                    </div>

                    <h3 class="text-2xl font-bold mb-4">I am a Developer</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        Create your specialized profile, showcase your Laravel projects, and get discovered by world-class companies and agencies.
                    </p>

                    <a href="{{ route('register') ?? '#' }}"
                       class="w-full py-4 bg-gray-100 dark:bg-gray-800 text-[#111418] dark:text-white font-bold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors inline-flex items-center justify-center">
                        Find Your Next Role
                    </a>
                </div>
            </div>

            {{-- Featured Users Preview Section --}}
            @php
                $featured = [
                    [
                        'name' => 'Alex Rivera',
                        'title' => 'Fullstack Engineer',
                        'img' => "https://lh3.googleusercontent.com/aida-public/AB6AXuBpDNgRoeVddhRQWkg5W8KT437VFB2TD5xJimPNAhpy1s2FB6XSYt7dwZHzmshP81o-UnWJ7pMTp9aMM52RE3AuSuN_Z0DfSzrMJcIvRooMUZe-cLysxbIADuYE0aBZ7dLdpG4ImthzH0X8S9f9nU7sOeEh7gtrapkfG9f7M_Ethia0A36rOAAuUlZ0E3aXBseBMfx_b8qf2kbf7v_FyV0RUs04MAvHLv2iat1yxmOFSZASEWDNZnWO3y3Hu4-5Hj4wGE3NIH94N_zL",
                        'tags' => ['Livewire', 'Redis'],
                        'quote' => '"Passionate about scalable architectures and performance optimization."',
                    ],
                    [
                        'name' => 'Sarah Chen',
                        'title' => 'Backend Expert',
                        'img' => "https://lh3.googleusercontent.com/aida-public/AB6AXuDiC2oH54AicbkWK4yaKglNg1-5rIOYdLQLazYagXgAZbZZOBIJsSGGhM3V8cJQLlvze__j8TyPJPacuIFv7RAu3bTnCWDQXPXGjkUut4UxOsxxcNINNmgiF6jj54zxPqpFF5JJl0PxubmgAZWgW67zBxxFgbgv5bSKDppRz4lhRlWmMvgWLdQ8QD9e53Al3hgtxChkwius748gz8-OEst51fbEoNtQwKuOiYtCpQohNP7HtJ5ISoxbo_qBXDAj56HACtTZASZ0DlpV",
                        'tags' => ['Laravel', 'AWS'],
                        'quote' => '"Building robust APIs for the next generation of fintech apps."',
                    ],
                    [
                        'name' => 'Marcus Thorne',
                        'title' => 'UI/UX Developer',
                        'img' => "https://lh3.googleusercontent.com/aida-public/AB6AXuBkdBepKxlntpwGovS5EG1IykpgbCBXi5vXZhdBPnExyHLiwrtsTMthQqkXEVVzBViICcUGHof9MjaLUUtNjOVXskneXJItP8pdYjZxCiTKcFEfd7SaNWgGf2hQ2YBPYZHJe8QS-Qf5zfrZ6URewXCN2mkB77ccaU_w_AXHayBUZ2bh2UbMEYGKcJ6QXEO9RdcC8Ma0hFyBVSO53g28Nffyylov4Mk20p6S8SEA8Y2gpMG9OY0OMUBYyW4ApkzPgvZLPoerZjyrookD",
                        'tags' => ['Tailwind', 'Figma'],
                        'quote' => '"Focusing on the intersection of design and Laravel productivity."',
                    ],
                    [
                        'name' => 'Elena Gomez',
                        'title' => 'DevOps Engineer',
                        'img' => "https://lh3.googleusercontent.com/aida-public/AB6AXuDo5KSgc5pB5dEKhkbJebXOeAPC3YH5EU9zvJs4knnAvEY6X4XGOUgQvNwWcf63kduU--tpvFH9p03KqN7INfSSZwa4R9eqtqbYAYTRpIq2SsTWOdNnaUqmp8ai2L6iRa-uvGAt7t78gXCS-oyotR-aCBsyNzG-7f2opYaP4SXhAG2t-cY4EXoutU7kJ_bCI9r8u424kX-owj6Y6bHQrmIM46w_6W7QiO0bcQ4RGP2dwYtb4hBDXGuZXIQ5GMyMjCi7zPDji9jqH60z",
                        'tags' => ['Docker', 'Forge'],
                        'quote' => '"Optimizing CI/CD pipelines for high-traffic Laravel platforms."',
                    ],
                ];
            @endphp

            <div class="mb-20">
                <div class="flex items-center justify-between mb-8 px-2">
                    <h2 class="text-2xl font-bold">Featured Laravel Experts</h2>
                    <a class="text-primary font-semibold flex items-center gap-1 hover:underline" href="#">
                        View all <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featured as $u)
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-5 hover:border-primary/40 transition-all cursor-pointer">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="size-12 rounded-full bg-cover bg-center"
                                     style="background-image: url('{{ $u['img'] }}');"></div>
                                <div>
                                    <h4 class="font-bold">{{ $u['name'] }}</h4>
                                    <p class="text-xs text-gray-500">{{ $u['title'] }}</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach($u['tags'] as $t)
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-[10px] font-bold rounded">{{ $t }}</span>
                                @endforeach
                            </div>

                            <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 italic">
                                {{ $u['quote'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Social Proof Stats --}}
            <section class="grid grid-cols-2 md:grid-cols-4 gap-8 py-12 border-t border-gray-200 dark:border-gray-800">
                <div class="text-center">
                    <p class="text-4xl font-black text-primary">12k+</p>
                    <p class="text-sm font-medium text-gray-500 uppercase">Developers</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-black text-primary">850+</p>
                    <p class="text-sm font-medium text-gray-500 uppercase">Companies</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-black text-primary">2.4k</p>
                    <p class="text-sm font-medium text-gray-500 uppercase">Open Roles</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-black text-primary">$4M+</p>
                    <p class="text-sm font-medium text-gray-500 uppercase">Hired Value</p>
                </div>
            </section>
        </main>

        {{-- Simple Footer --}}
        <footer class="bg-white dark:bg-gray-900 py-12 border-t border-gray-100 dark:border-gray-800">
            <div class="max-w-[1200px] mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="text-lg font-bold tracking-tight">LaravelJobConnect</span>
                    <span class="text-xs text-gray-400">© {{ date('Y') }}</span>
                </div>

                <div class="flex gap-8">
                    <a class="text-sm text-gray-500 hover:text-primary" href="#">Privacy Policy</a>
                    <a class="text-sm text-gray-500 hover:text-primary" href="#">Terms of Service</a>
                    <a class="text-sm text-gray-500 hover:text-primary" href="#">Contact Support</a>
                </div>

                <div class="flex gap-4">
                    <button class="size-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-lg">public</span>
                    </button>
                    <button class="size-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-lg">alternate_email</span>
                    </button>
                </div>
            </div>
        </footer>

    </div>
@endsection
