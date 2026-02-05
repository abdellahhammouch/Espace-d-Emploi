<x-app-layout>
    <x-slot name="header">Search Results</x-slot>

    <div class="space-y-8">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black tracking-tight">Search Results</h1>
                <p class="text-[#617589]">Query: <span class="font-bold text-[#111418]">{{ $q ?: '—' }}</span></p>
                <p class="text-xs text-[#617589] mt-1">{{ $users->count() }} result(s)</p>
            </div>

            <a href="{{ route('search.index', ['q' => $q]) }}"
               class="px-5 py-2 rounded-xl bg-white border border-[#e5e7eb] font-bold hover:border-primary/30 transition">
                Back to search
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($users as $u)
                @php
                    $isFriend = in_array($u->id, $friendIds);
                    $sentPending = in_array($u->id, $sentPendingIds);
                    $incomingReqId = $incomingPendingMap[$u->id] ?? null;

                    $title = $u->hasRole('recruiter')
                        ? ($u->recruiterProfile?->company_name ?? 'Recruiter')
                        : ($u->employeeProfile?->speciality?->name ?? $u->employeeProfile?->speciality ?? 'Employee');

                    $avatar = $u->avatar_path
                        ? \Illuminate\Support\Facades\Storage::url($u->avatar_path)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=137fec&color=ffffff&bold=true';
                @endphp

                <div class="bg-white dark:bg-[#1a2633] rounded-xl border border-[#e5e7eb] dark:border-[#2d3748] p-5 flex flex-col items-center text-center shadow-sm">
                    <div class="size-24 rounded-full bg-cover bg-center mb-4 ring-4 ring-background-light dark:ring-[#2d3748]"
                         style="background-image:url('{{ $avatar }}')"></div>

                    <a href="{{ route('users.show', $u) }}" class="text-lg font-bold text-[#111418] dark:text-white hover:underline">
                        {{ $u->name }}
                    </a>
                    <p class="text-primary text-sm font-semibold mb-6">{{ $title }}</p>

                    {{-- Actions (Blade) --}}
                    @if($incomingReqId)
                        <div class="w-full mt-auto flex gap-2">
                            <form class="flex-1" method="POST" action="{{ route('connections.accept', $incomingReqId) }}">
                                @csrf
                                <button class="w-full py-2.5 bg-primary text-white rounded-lg font-semibold text-sm hover:bg-primary/90">
                                    Accept
                                </button>
                            </form>

                            <form class="flex-1" method="POST" action="{{ route('connections.decline', $incomingReqId) }}">
                                @csrf
                                <button class="w-full py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-lg font-semibold text-sm hover:bg-red-100">
                                    Ignore
                                </button>
                            </form>
                        </div>

                    @elseif($isFriend)
                        <a href="{{ route('users.show', $u) }}"
                           class="w-full mt-auto py-2.5 border border-primary text-primary hover:bg-primary/10 rounded-lg font-semibold flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                            Connected
                        </a>

                    @elseif($sentPending)
                        <button disabled
                                class="w-full mt-auto py-2.5 bg-[#f0f2f4] text-[#617589] rounded-lg font-semibold flex items-center justify-center gap-2 cursor-not-allowed">
                            <span class="material-symbols-outlined text-[20px]">hourglass_empty</span>
                            Pending
                        </button>

                    @else
                        <form method="POST" action="{{ route('connections.request', $u) }}" class="w-full mt-auto">
                            @csrf
                            <button class="w-full py-2.5 bg-primary text-white rounded-lg font-semibold flex items-center justify-center gap-2 hover:bg-primary/90">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                                Connect
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-sm text-[#617589]">No results.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
