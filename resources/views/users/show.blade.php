<x-app-layout>
    <x-slot name="header">Profil</x-slot>

    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <div class="text-2xl font-extrabold">{{ $user->name }}</div>
            <div class="text-slate-500">{{ $user->email }}</div>
            <div class="mt-3 text-slate-700">{{ $user->bio }}</div>
        </div>

        @if($user->employeeProfile)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-3">
                <div class="font-bold">CV</div>

                <div class="text-sm text-slate-600">
                    Spécialité:
                    {{ $user->employeeProfile?->speciality?->name ?? $user->employeeProfile?->speciality ?? '-' }}
                </div>

                <div>
                    <div class="font-semibold mb-2">Expériences</div>
                    <ul class="list-disc pl-5 text-sm text-slate-700 space-y-1">
                        @foreach($user->employeeProfile->experiences as $e)
                            <li>{{ $e->job_title }} - {{ $e->company }}</li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <div class="font-semibold mb-2">Formations</div>
                    <ul class="list-disc pl-5 text-sm text-slate-700 space-y-1">
                        @foreach($user->employeeProfile->educations as $ed)
                            <li>{{ $ed->degree }} - {{ $ed->school }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
