<x-app-layout>
    <x-slot name="header">Candidatures reçues</x-slot>

    <div class="max-w-5xl mx-auto p-6 space-y-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-4">
            <div class="font-bold">{{ $offer->title }}</div>
            <div class="text-sm text-slate-500">{{ $offer->place }}</div>
        </div>

        <div class="space-y-3">
            @foreach($applications as $app)
                @php
                    $emp = $app->employee;
                    $spec = $emp->employeeProfile?->speciality?->name
                            ?? $emp->employeeProfile?->speciality
                            ?? '-';
                @endphp

                <div class="bg-white rounded-2xl border border-slate-200 p-4 flex items-center justify-between">
                    <div>
                        <div class="font-bold">{{ $emp->name }}</div>
                        <div class="text-sm text-slate-500">Spécialité: {{ $spec }} • Status: {{ $app->status }}</div>
                        @if($app->note)
                            <div class="text-sm text-slate-700 mt-2 whitespace-pre-line">{{ $app->note }}</div>
                        @endif
                    </div>

                    <a class="rounded-xl px-3 py-2 border border-slate-200" href="{{ route('users.show', $emp) }}">
                        Voir profil
                    </a>
                </div>
            @endforeach
        </div>

        {{ $applications->links() }}
    </div>
</x-app-layout>
