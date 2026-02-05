@php
    $user = auth()->user();

    $initials = collect(preg_split('/\s+/', trim($user?->name ?? 'U')))
        ->filter()
        ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
        ->take(2)
        ->join('');

    $avatarUrl = $user && $user->avatar_path
        ? asset('storage/' . $user->avatar_path)
        : null;

    $bannerUrl = $user && isset($user->banner_path) && $user->banner_path
        ? asset('storage/' . $user->banner_path)
        : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RecruitConnect') }}</title>

    {{-- Fonts + Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f6f7f8] text-[#111418] font-['Inter'] min-h-screen">

    {{-- Top Nav (maquette) --}}
    @include('layouts.recruitconnect.nav')


    <main class="max-w-7xl mx-auto px-4 md:px-10 lg:px-20 py-8">
        {{ $slot }}
    </main>

</body>
</html>
