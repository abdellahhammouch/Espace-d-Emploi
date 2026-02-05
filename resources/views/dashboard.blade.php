<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Job Seeker Dashboard - RecruitConnect')</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>

    {{-- Tailwind config --}}
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
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

    @stack('head')
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-slate-200">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">

        {{-- Top Navigation Bar --}}
        <x-recruitconnect-layout>
        <div class="flex flex-1 justify-center py-8 px-6 lg:px-20 gap-8">

            {{-- Sidebar Column --}}
            <aside class="hidden lg:flex flex-col w-64 gap-6 shrink-0">

                {{-- Profile Navigation Card --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-[#e7ebf3] dark:border-slate-800 p-4 shadow-sm">
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-3 items-center">
                            <div
                                class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12"
                                data-alt="Profile image"
                                style='background-image: url("{{ $profileImageUrl ?? "https://lh3.googleusercontent.com/aida-public/AB6AXuDmTpfgu5-dHMKcfFPYAuL_0s9RNiK_tJEQmsa5lyg_kM4fNVIuqhj_1omgn7tn_coZzDwcNUeF7QdKV7htjSjVn263AQPGn-htGkSUx83q8iGpamB2Ji-5FBEf4m_tL81YCaITbN5KzDaPl1r8G8UMyasnSjQoN8Dsme2CVbAlZWAC9I7y1BI5uSSdXwLDMnVtgEdRepJmCgHQPBQ9SNKXUypJbTnBNoXKiTVbb8HRrTfKrv7DUQZfv-3xhwp42wTwp4DQ1Q19gJb6" }}");'>
                            </div>
                            <div class="flex flex-col">
                                <h1 class="text-[#0d121b] dark:text-white text-sm font-bold">
                                    {{ $userName ?? 'Alex Rivera' }}
                                </h1>
                                <p class="text-[#4c669a] dark:text-slate-400 text-xs">
                                    {{ $userRole ?? 'Product Designer' }}
                                </p>
                            </div>
                        </div>

                        <hr class="border-[#e7ebf3] dark:border-slate-800"/>

                        <nav class="flex flex-col gap-1">
                            <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary" href="#">
                                <span class="material-symbols-outlined text-[20px]">home</span>
                                <p class="text-sm font-medium">Home</p>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2 text-[#4c669a] dark:text-slate-400 hover:bg-background-light dark:hover:bg-slate-800 rounded-lg transition-colors" href="#">
                                <span class="material-symbols-outlined text-[20px]">work</span>
                                <p class="text-sm font-medium">Jobs</p>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2 text-[#4c669a] dark:text-slate-400 hover:bg-background-light dark:hover:bg-slate-800 rounded-lg transition-colors" href="#">
                                <span class="material-symbols-outlined text-[20px]">group</span>
                                <p class="text-sm font-medium">Network</p>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2 text-[#4c669a] dark:text-slate-400 hover:bg-background-light dark:hover:bg-slate-800 rounded-lg transition-colors" href="#">
                                <span class="material-symbols-outlined text-[20px]">forum</span>
                                <p class="text-sm font-medium">Messages</p>
                            </a>
                            <a class="flex items-center gap-3 px-3 py-2 text-[#4c669a] dark:text-slate-400 hover:bg-background-light dark:hover:bg-slate-800 rounded-lg transition-colors" href="#">
                                <span class="material-symbols-outlined text-[20px]">settings</span>
                                <p class="text-sm font-medium">Settings</p>
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- Profile Strength Widget --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-[#e7ebf3] dark:border-slate-800 p-4 shadow-sm">
                    <div class="flex flex-col gap-3">
                        <div class="flex gap-6 justify-between items-center">
                            <p class="text-[#0d121b] dark:text-white text-sm font-bold">Profile Strength</p>
                            <p class="text-primary text-xs font-bold">{{ $profileStrength ?? 85 }}%</p>
                        </div>
                        <div class="rounded-full bg-[#cfd7e7] dark:bg-slate-700 h-2 overflow-hidden">
                            <div class="h-2 rounded-full bg-primary" style="width: {{ $profileStrength ?? 85 }}%;"></div>
                        </div>
                        <p class="text-[#4c669a] dark:text-slate-400 text-xs leading-normal">
                            Complete your profile to get 2x more views from recruiters.
                        </p>
                        <button class="mt-2 text-primary text-xs font-bold hover:underline text-left">Improve now</button>
                    </div>
                </div>

            </aside>

            {{-- Main Content Column --}}
            <main class="flex flex-col flex-1 max-w-[800px] gap-8">

                {{-- Profile Header --}}
                <section class="bg-white dark:bg-slate-900 rounded-xl border border-[#e7ebf3] dark:border-slate-800 overflow-hidden shadow-sm">
                    <div class="h-32 w-full bg-gradient-to-r from-primary to-blue-400"></div>
                    <div class="px-8 py-8 flex flex-col md:flex-row items-start gap-6">
                        <div class="-mt-16 bg-white dark:bg-slate-900 p-1 rounded-full">
                            <div
                                class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-32 w-32 border-4 border-white dark:border-slate-900"
                                data-alt="Profile picture"
                                style='background-image: url("{{ $profileImageLargeUrl ?? "https://lh3.googleusercontent.com/aida-public/AB6AXuC1P50gPVDMX-LWjHryvCJbovVxAVM2fK84wplT2SciFVTxq9TYiycXnu8flYRzw-bJk332-Go1OmZlbxzhRHGK74HCEd6W1KQyHtChJKr9h6TNWi_K0iwSaB6wj4Rp43rYoL24PuBeaYU24z1ty7RbIIWTmJDbrGKvy65SV-RoWFXQVYvsAmkAqc__1QN0QjhKL9c-OMRn59Y_Kd-eSh7g7g2FDeX0Tn6A8RQyYXK3AkNWPj4a5aQ-iuEigUS9io5Yvgc_-WHw760h" }}");'>
                            </div>
                        </div>

                        <div class="flex flex-col pb-2 grow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-[#0d121b] dark:text-white text-2xl font-bold tracking-tight">
                                        {{ $userName ?? 'Alex Rivera' }}
                                    </h2>
                                    <p class="text-[#4c669a] dark:text-slate-400 text-base font-medium">
                                        {{ $headline ?? 'Product Designer @ TechSolutions' }}
                                    </p>
                                </div>
                                <button class="flex items-center justify-center rounded-lg h-10 px-6 bg-primary text-white text-sm font-bold hover:bg-blue-700 transition-colors">
                                    View Profile
                                </button>
                            </div>

                            <p class="text-[#4c669a] dark:text-slate-400 text-sm mt-3 leading-relaxed max-w-2xl">
                                {{ $bio ?? 'Experienced in building scalable design systems and intuitive user interfaces. Passionate about accessibility, design thinking, and clean code. Looking for remote opportunities.' }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Connection Requests --}}
                <section>
                    <div class="flex items-center justify-between px-4 pb-4">
                        <h2 class="text-[#0d121b] dark:text-white text-lg font-bold">Connection Requests</h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">
                            See all ({{ $connectionRequestsCount ?? 12 }})
                        </a>
                    </div>

                    <div class="flex flex-col gap-3">
                        @php
                            $requests = $requests ?? [
                                [
                                    'name' => 'Sarah Jenkins',
                                    'title' => 'Senior Recruiter at GlobalTech',
                                    'mutual' => 4,
                                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_CRxKlDRKTTPjgH149i8RzylvvNCprSLiKppRuNU-7gW5M1KHaXtj4aNywANJvhtKfQusLyYdAqJffjnF8G3kA0QcKtNjo-BaoRn3s1PlnOXozBmmweESx_tm1EwoOqZ0YtLzZx83nwPTEJRSNEU-DqRR_RO3uA9tENAXBLnLkjGZ0iRgg7Il4cAVSvyJ7LZwiLMcnC1LOHLs4vFxZXiRKJd_iGnRtv9cylLfUUGZ_bI0RnLDEw04_DPfXuS3TGMvWfIGR1mG0uEa',
                                ],
                                [
                                    'name' => 'Michael Chen',
                                    'title' => 'Engineering Manager at FlowState',
                                    'mutual' => 8,
                                    'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCmh5LgKef1QQV6m7oo6hFjc7wgRtWeL7-jEac0_iaxOIKVQ4kq66Yg_L74syCXDcIDWGvscqfX_-D-BIyFy5_apuptPJ2MXNAiLENO6TUxHO9eg8VTtYaT3ZYxUBk5awQU3DS1TgzzaWIawq9n-T3DjmOrrcgaC8EVSmLRnHf670QYCzNLDB7jJTqB2TbvhWGgCI6ivk1LIWkELjI0s6SHTwfG3gSUcy9_pX_r5STJBOeWmR5E9ZdMTO28kBVj42YoDEwniAnjY0bO',
                                ],
                            ];
                        @endphp

                        @foreach ($requests as $req)
                            <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-900 rounded-xl border border-[#e7ebf3] dark:border-slate-800 shadow-sm transition-hover hover:border-primary/30">
                                <div class="flex gap-4 items-center">
                                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-14"
                                         data-alt="Portrait"
                                         style='background-image: url("{{ $req["avatar"] }}");'>
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-[#0d121b] dark:text-white text-sm font-bold">{{ $req['name'] }}</p>
                                        <p class="text-[#4c669a] dark:text-slate-400 text-xs">{{ $req['title'] }}</p>
                                        <p class="text-[#4c669a] dark:text-slate-500 text-[11px] mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">link</span>
                                            {{ $req['mutual'] }} mutual connections
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <button class="h-9 px-4 rounded-lg bg-primary text-white text-xs font-bold hover:bg-blue-700">Accept</button>
                                    <button class="h-9 px-4 rounded-lg bg-background-light dark:bg-slate-800 text-[#0d121b] dark:text-white text-xs font-bold hover:bg-slate-200 dark:hover:bg-slate-700">Ignore</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Suggested Connections --}}
                <section>
                    <div class="flex items-center justify-between px-4 pb-4">
                        <h2 class="text-[#0d121b] dark:text-white text-lg font-bold">Suggested for you</h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View more</a>
                    </div>

                    @php
                        $suggested = $suggested ?? [
                            [
                                'name' => 'Elena Rodriguez',
                                'title' => 'Lead UI Designer @ CreativeStudio',
                                'mutual' => 15,
                                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBLUALIoCRHQkHGtoYQBjTqCRYjIEYznMWFIcq_j3B71Hc6imxypH4EFWCDgqKD5xDsx-vWzJbceLC7rraLcXntBdqU_SeTVyOPSkhXHT64yZ5b8colK5n1HEJowwMOvKdkRgqlVI0LUFUHBMVKC5j6XGEvrXuvG70wDaFVqjby53Hs-_XKY0EV_uOxCTkyPqUHdxpC0PfCVlFOhIO7jrjxaUrRFyLsZpWOUlhz6Hy0w7prD4UnaxYONOWkFvkvp5RCT69Jsv6B8NyB',
                            ],
                            [
                                'name' => 'David Wu',
                                'title' => 'Director of HR @ InnovateHub',
                                'mutual' => 3,
                                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDhLt9L8y1axOq5NyPmci3LqIS-4FT2lm-FVVRCU_1rZFl7QmoWPbOx2klTlh8OVM2c_TgoVtWbNgzLYgx6_R2A6Bb9o3qze9XJYMoAQo0wH7ZHhnxlDZR5qKuZtf5_z7sTILsHDMYv1o9-CABMYpIAbJRbb-NPltZOjwDEiTaSwPw6kQbM4vDJLtxq0ZcsLu3sxxlrEScONcLQaaWeUQXEJVCHkDsEhLorxIl4qcJG0iNQa9hvJWoVtdsMieDGM9pXAWT2X0CwysuQ',
                            ],
                            [
                                'name' => 'Jessica Taylor',
                                'title' => 'Product Manager @ CloudScale',
                                'mutual' => 22,
                                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBGq7MBlmH9UnXm_4yN8MRIdkUTjivLm7oyoOwACiAzs7ND4GyPEqB5WTOW07LBwxawlazPwita-FAPMabCTSPrYOt1k0scLKxo07HGh9mXUhtM2cuuYfQGCDGMjw_dWBmI1etWUrO-UcPKDnv3T2cB5KaCQ05tRdnT2kUTWMHPF1_0gzSHSNlTEbVNuEbMUPug9dNGEEiG6nNbvTvOL1QiJCZP3EHztfhtFDXNoc_SDkFI8J1iBmjZnrauuq85xeVFzPwZy3qkfhLa',
                            ],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($suggested as $s)
                            <div class="bg-white dark:bg-slate-900 rounded-xl border border-[#e7ebf3] dark:border-slate-800 p-5 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-shadow">
                                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-20 mb-3 border-2 border-primary/10"
                                     data-alt="Profile image"
                                     style='background-image: url("{{ $s["avatar"] }}");'>
                                </div>
                                <h3 class="text-[#0d121b] dark:text-white text-sm font-bold">{{ $s['name'] }}</h3>
                                <p class="text-[#4c669a] dark:text-slate-400 text-xs line-clamp-1 mb-2">{{ $s['title'] }}</p>
                                <p class="text-[#4c669a] dark:text-slate-500 text-[10px] mb-4">{{ $s['mutual'] }} mutual connections</p>
                                <button class="w-full h-9 rounded-lg border border-primary text-primary text-xs font-bold hover:bg-primary/5 transition-colors">
                                    Connect
                                </button>
                            </div>
                        @endforeach
                    </div>
                </section>

            </main>

            {{-- Right Sidebar --}}
            <aside class="hidden xl:flex flex-col w-72 gap-6 shrink-0">

                {{-- Recommended Jobs --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-[#e7ebf3] dark:border-slate-800 p-5 shadow-sm">
                    <h3 class="text-[#0d121b] dark:text-white text-sm font-bold mb-4">Recommended Jobs</h3>

                    @php
                        $jobs = $jobs ?? [
                            ['title' => 'Senior Product Designer', 'meta' => 'Meta • Remote • 2 days ago'],
                            ['title' => 'Design Systems Lead', 'meta' => 'Airbnb • San Francisco, CA • 1 day ago'],
                            ['title' => 'UI/UX Strategist', 'meta' => 'Spotify • Stockholm, SE • 4 hours ago'],
                        ];
                    @endphp

                    <div class="flex flex-col gap-4">
                        @foreach ($jobs as $job)
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-bold text-[#0d121b] dark:text-white hover:text-primary cursor-pointer">
                                    {{ $job['title'] }}
                                </p>
                                <p class="text-xs text-[#4c669a] dark:text-slate-400">{{ $job['meta'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <button class="w-full mt-6 text-primary text-xs font-bold border border-primary/20 h-9 rounded-lg hover:bg-primary/5">
                        View all recommendations
                    </button>
                </div>

                {{-- Trending Articles --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-[#e7ebf3] dark:border-slate-800 p-5 shadow-sm">
                    <h3 class="text-[#0d121b] dark:text-white text-sm font-bold mb-4">Trending Articles</h3>

                    @php
                        $articles = $articles ?? [
                            ['title' => 'Remote Work in 2024: Trends and Challenges', 'meta' => '1.2k readers • 5 min read'],
                            ['title' => 'AI in Design: Friend or Foe?', 'meta' => '850 readers • 8 min read'],
                        ];
                    @endphp

                    <ul class="flex flex-col gap-3">
                        @foreach ($articles as $a)
                            <li class="group">
                                <a class="flex flex-col gap-0.5" href="#">
                                    <span class="text-xs font-bold group-hover:text-primary leading-tight">{{ $a['title'] }}</span>
                                    <span class="text-[10px] text-[#4c669a]">{{ $a['meta'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </aside>

        </div>
    </div>
</div>

@stack('scripts')
</body>
</html>
