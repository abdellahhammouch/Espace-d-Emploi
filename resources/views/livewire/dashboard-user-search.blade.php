<div class="space-y-4">
    <div class="w-full">
        <div class="relative flex items-center h-14 bg-white dark:bg-[#1a2633] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-[#2d3748]">
            <span class="absolute left-5 text-[#617589] material-symbols-outlined text-[28px]">search</span>

            <input
                wire:model.live.debounce.300ms="q"
                wire:keydown.enter.prevent="goToSearch"
                class="w-full h-full pl-14 pr-32 rounded-xl text-base md:text-lg text-[#111418] dark:text-white bg-transparent border-none focus:ring-2 focus:ring-primary placeholder:text-[#617589]"
                placeholder="Rechercher par nom, spécialité ou entreprise..."
            />

            <button
                wire:click="goToSearch"
                class="absolute right-3 bg-primary text-white px-5 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-all">
                Rechercher
            </button>
        </div>
    </div>

    @if(trim($q) !== '')
        @if($results->isEmpty())
            <div class="text-sm text-[#617589]">
                Aucun résultat pour “{{ $q }}”.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($results as $u)
                    @php
                        $isFriend = in_array($u->id, $friendIds);
                        $sentPending = in_array($u->id, $sentPendingIds);
                        $incomingReqId = $incomingPendingMap[$u->id] ?? null;

                        $title = $u->employeeProfile?->speciality
                            ?? $u->employeeProfile?->speciality?->name
                            ?? $u->recruiterProfile?->company_name
                            ?? 'Profil';

                        $avatar = $u->avatar_path
                            ? \Illuminate\Support\Facades\Storage::url($u->avatar_path)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=137fec&color=ffffff&bold=true';
                    @endphp

                    <div class="bg-white dark:bg-[#1a2633] rounded-xl border border-[#e5e7eb] dark:border-[#2d3748] p-5 flex flex-col items-center text-center shadow-sm">
                        <div class="size-20 rounded-full bg-cover bg-center mb-3 ring-4 ring-background-light dark:ring-[#2d3748]"
                             style="background-image:url('{{ $avatar }}')"></div>

                        <a href="{{ route('users.show', $u->id) }}" class="text-base font-bold text-[#111418] dark:text-white hover:underline">
                            {{ $u->name }}
                        </a>
                        <p class="text-primary text-sm font-semibold mb-4">{{ $title }}</p>

                        @if($incomingReqId)
                            <div class="w-full mt-auto flex gap-2">
                                <button wire:click="acceptRequest({{ $incomingReqId }})"
                                        class="flex-1 py-2 bg-primary text-white rounded-lg font-semibold text-sm hover:bg-primary/90">
                                    Accept
                                </button>
                                <button wire:click="declineRequest({{ $incomingReqId }})"
                                        class="flex-1 py-2 bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50 rounded-lg font-semibold text-sm hover:bg-red-100">
                                    Ignore
                                </button>
                            </div>
                        @elseif($isFriend)
                            <a href="{{ route('users.show', $u->id) }}"
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

            <div class="pt-2">
                <a class="text-primary text-sm font-semibold hover:underline"
                   href="{{ route('users.search', ['q' => trim($q)]) }}">
                    Voir tous les résultats →
                </a>
            </div>
        @endif
    @endif
</div>
