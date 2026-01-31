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
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-[#e7ebf3] dark:border-slate-800 bg-white dark:bg-background-dark px-10 py-3 sticky top-0 z-50">
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-4 text-primary">
                    <div class="size-8">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.8261 17.4264C16.7203 18.1174 20.2244 18.5217 24 18.5217C27.7756 18.5217 31.2797 18.1174 34.1739 17.4264C36.9144 16.7722 39.9967 15.2331 41.3563 14.1648L24.8486 40.6391C24.4571 41.267 23.5429 41.267 23.1514 40.6391L6.64374 14.1648C8.00331 15.2331 11.0856 16.7722 13.8261 17.4264Z" fill="currentColor"></path>
                            <path clip-rule="evenodd" d="M39.998 12.236C39.9944 12.2537 39.9875 12.2845 39.9748 12.3294C39.9436 12.4399 39.8949 12.5741 39.8346 12.7175C39.8168 12.7597 39.7989 12.8007 39.7813 12.8398C38.5103 13.7113 35.9788 14.9393 33.7095 15.4811C30.9875 16.131 27.6413 16.5217 24 16.5217C20.3587 16.5217 17.0125 16.131 14.2905 15.4811C12.0012 14.9346 9.44505 13.6897 8.18538 12.8168C8.17384 12.7925 8.16216 12.767 8.15052 12.7408C8.09919 12.6249 8.05721 12.5114 8.02977 12.411C8.00356 12.3152 8.00039 12.2667 8.00004 12.2612C8.00004 12.261 8 12.2607 8.00004 12.2612C8.00004 12.2359 8.0104 11.9233 8.68485 11.3686C9.34546 10.8254 10.4222 10.2469 11.9291 9.72276C14.9242 8.68098 19.1919 8 24 8C28.8081 8 33.0758 8.68098 36.0709 9.72276C37.5778 10.2469 38.6545 10.8254 39.3151 11.3686C39.9006 11.8501 39.9857 12.1489 39.998 12.236ZM4.95178 15.2312L21.4543 41.6973C22.6288 43.5809 25.3712 43.5809 26.5457 41.6973L43.0534 15.223C43.0709 15.1948 43.0878 15.1662 43.104 15.1371L41.3563 14.1648C43.104 15.1371 43.1038 15.1374 43.104 15.1371L43.1051 15.135L43.1065 15.1325L43.1101 15.1261L43.1199 15.1082C43.1276 15.094 43.1377 15.0754 43.1497 15.0527C43.1738 15.0075 43.2062 14.9455 43.244 14.8701C43.319 14.7208 43.4196 14.511 43.5217 14.2683C43.6901 13.8679 44 13.0689 44 12.2609C44 10.5573 43.003 9.22254 41.8558 8.2791C40.6947 7.32427 39.1354 6.55361 37.385 5.94477C33.8654 4.72057 29.133 4 24 4C18.867 4 14.1346 4.72057 10.615 5.94478C8.86463 6.55361 7.30529 7.32428 6.14419 8.27911C4.99695 9.22255 3.99999 10.5573 3.99999 12.2609C3.99999 13.1275 4.29264 13.9078 4.49321 14.3607C4.60375 14.6102 4.71348 14.8196 4.79687 14.9689C4.83898 15.0444 4.87547 15.1065 4.9035 15.1529C4.91754 15.1762 4.92954 15.1957 4.93916 15.2111L4.94662 15.223L4.95178 15.2312ZM35.9868 18.996L24 38.22L12.0131 18.996C12.4661 19.1391 12.9179 19.2658 13.3617 19.3718C16.4281 20.1039 20.0901 20.5217 24 20.5217C27.9099 20.5217 31.5719 20.1039 34.6383 19.3718C35.082 19.2658 35.5339 19.1391 35.9868 18.996Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-[#0d121b] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">
                        RecruitConnect
                    </h2>
                </div>

                <label class="flex flex-col min-w-40 !h-10 max-w-64">
                    <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                        <div class="text-[#4c669a] flex border-none bg-[#e7ebf3] dark:bg-slate-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </div>
                        <input
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0d121b] dark:text-white focus:outline-0 focus:ring-0 border-none bg-[#e7ebf3] dark:bg-slate-800 focus:border-none h-full placeholder:text-[#4c669a] px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal"
                            placeholder="Search for jobs or people"
                            value=""
                        />
                    </div>
                </label>
            </div>

            <div class="flex flex-1 justify-end gap-8">
                <div class="flex gap-2">
                    <button class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 bg-[#e7ebf3] dark:bg-slate-800 text-[#0d121b] dark:text-white gap-2 text-sm font-bold min-w-0 px-2.5">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 bg-[#e7ebf3] dark:bg-slate-800 text-[#0d121b] dark:text-white gap-2 text-sm font-bold min-w-0 px-2.5">
                        <span class="material-symbols-outlined">chat_bubble</span>
                    </button>
                </div>

                {{-- Exemple : avatar venant de l'utilisateur connecté --}}
                <div
                    class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary/20"
                    data-alt="User avatar"
                    style='background-image: url("{{ $userAvatarUrl ?? "https://lh3.googleusercontent.com/aida-public/AB6AXuAuaoZotJFtwD2qf6q-RHG1nfJBYz-uN0i_JKTqsNglo8JyWMSBQamy_liTYGGp5ouyEBWGHSSI_9wbvX5Ytp925GDy5OYyOpXenB2R8F1s_as-Ah12lFRQ2QpnSlMGKdt9wunUlPO3dAHNsHmkJgLXE4JBtao35k5DlIcRApLw8IttTVLElDlmxKdFmSvC-HQiVoKXkZs3xLEjnVUi3XsE411x_FHQ3YRn_LCZevxgNye7VQQ259-l7OdXIEg_9hgmy41VpQ3ou_ku" }}");'>
                </div>
            </div>
        </header>

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
