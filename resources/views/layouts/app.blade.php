<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Espace d’Emploi') }}</title>

    {{-- Fonts + Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-background-light text-ink font-display">
    @include('layouts.recruitconnect.nav')
    <main class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-20 py-8">
        @php
            $status = session('status');
            $map = [
                'offer-created'     => 'Offre créée avec succès.',
                'offer-updated'     => 'Offre mise à jour.',
                'offer-closed'      => 'Offre clôturée.',
                'application-sent'  => 'Candidature envoyée.',
                'profile-updated'   => 'Profil mis à jour.',
                'password-updated'  => 'Mot de passe mis à jour.',
            ];
            $flash = $status ? ($map[$status] ?? $status) : null;
        @endphp

        @if($flash)
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm font-semibold">
                {{ $flash }}
            </div>
        @endif

        @isset($header)
            <header class="mb-7">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="text-2xl md:text-3xl font-black tracking-tight leading-tight">
                            {{ $header }}
                        </div>
                        <p class="text-muted mt-1 text-sm md:text-base">
                            {{ $description ?? '' }}
                        </p>
                    </div>
                </div>
            </header>
        @endisset

        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>
