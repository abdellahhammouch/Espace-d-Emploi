<div class="space-y-8">
    {{-- Barre de recherche --}}
    <div class="relative flex items-center h-14 bg-white dark:bg-[#1a2633] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-[#2d3748]">
        <span class="absolute left-5 text-[#617589] material-symbols-outlined text-[28px]">search</span>

        <input
            wire:model.live.debounce.300ms="q"
            wire:keydown.enter.prevent="goToResults"
            class="w-full h-full pl-14 pr-36 rounded-xl text-lg text-[#111418] dark:text-white bg-transparent border-none focus:ring-2 focus:ring-primary placeholder:text-[#617589]"
            placeholder="Search by name, specialty, or company..."
        />

        <button
            wire:click="goToResults"
            class="absolute right-3 bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-all">
            Rechercher
        </button>
    </div>

    {{-- Résultats Live (sans cliquer) --}}
    @if($q !== '')
        @if($users->isEmpty())
            <p class="text-sm text-[#617589]">Aucun résultat pour “{{ $q }}”.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($users as $u)
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

                        @if($incomingReqId)
                            <div class="w-full mt-auto flex gap-2">
                                <button wire:click="acceptRequest({{ $incomingReqId }})"
                                        class="flex-1 py-2.5 bg-primary text-white rounded-lg font-semibold text-sm hover:bg-primary/90">
                                    Accept
                                </button>

                                <button wire:click="declineRequest({{ $incomingReqId }})"
                                        class="flex-1 py-2.5 bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50 rounded-lg font-semibold text-sm hover:bg-red-100">
                                    Ignore
                                </button>
                            </div>

                        @elseif($isFriend)
                            <a href="{{ route('users.show', $u) }}"
                               class="w-full mt-auto py-2.5 border border-primary text-primary hover:bg-primary/10 rounded-lg font-semibold flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                Connected
                            </a>

                        @elseif($sentPending)
                            <button disabled
                                    class="w-full mt-auto py-2.5 bg-[#f0f2f4] dark:bg-[#2d3748] text-[#617589] rounded-lg font-semibold flex items-center justify-center gap-2 cursor-not-allowed">
                                <span class="material-symbols-outlined text-[20px]">hourglass_empty</span>
                                Pending
                            </button>

                        @else
                            <button wire:click="sendRequest({{ $u->id }})"
                                    class="w-full mt-auto py-2.5 bg-primary text-white rounded-lg font-semibold flex items-center justify-center gap-2 hover:bg-primary/90">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                                Connect
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
