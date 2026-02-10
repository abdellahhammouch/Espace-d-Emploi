<x-app-layout>
    <x-slot name="header">Connections</x-slot>

    <div class="space-y-8">
        {{-- Stats --}}
        <div class="flex flex-wrap gap-3">
            <div class="min-w-[140px] rounded-2xl bg-white border border-[#f0f2f4] p-4 shadow-soft">
                <p class="text-xs font-bold text-[#617589]">Pending</p>
                <p class="text-2xl font-black text-[#111418]">{{ $pendingCount }}</p>
            </div>
            <div class="min-w-[140px] rounded-2xl bg-white border border-[#f0f2f4] p-4 shadow-soft">
                <p class="text-xs font-bold text-[#617589]">Suggestions</p>
                <p class="text-2xl font-black text-[#111418]">{{ $suggestionsCount }}</p>
            </div>
        </div>

        {{-- Tabs --}}
        @php
            $tabClass = fn($t) => $tab === $t
                ? 'border-b-2 border-primary text-primary pb-3 font-extrabold'
                : 'border-b-2 border-transparent text-[#617589] pb-3 font-bold hover:text-[#111418]';
        @endphp
        <div class="flex gap-8 border-b border-[#e5e7eb]">
            <a class="{{ $tabClass('friends') }}" href="{{ route('connections.index', ['tab' => 'friends']) }}">
                My Friends <span
                    class="ml-2 text-[10px] px-2 py-0.5 rounded-full bg-primary/10 text-primary font-black">{{ $friendsCount }}</span>
            </a>

            <a class="{{ $tabClass('pending') }}" href="{{ route('connections.index', ['tab' => 'pending']) }}">
                Pending <span
                    class="ml-2 text-[10px] px-2 py-0.5 rounded-full bg-[#f0f2f4] text-[#617589] font-black">{{ $pendingCount }}</span>
            </a>

            <a class="{{ $tabClass('suggestions') }}" href="{{ route('connections.index', ['tab' => 'suggestions']) }}">
                Suggestions
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('connections.index') }}" class="max-w-md">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#617589]">search</span>
                <input name="q" value="{{ $q }}" class="w-full h-12 pl-12 pr-4 rounded-2xl bg-white border border-[#e5e7eb]
                           focus:ring-2 focus:ring-primary/30 focus:border-primary"
                    placeholder="Search by name / speciality / company...">
            </div>
        </form>

        {{-- Friends --}}
        @if($tab === 'friends')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse($friends as $u)
                    @php
                        $avatar = $u->avatar_path ? asset('storage/' . $u->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=137fec&color=ffffff&bold=true';
                        $title = $u->hasRole('recruiter')
                            ? (optional($u->recruiterProfile)->company_name ?? 'Recruiter')
                            : (optional(optional($u->employeeProfile)->speciality)->name ?? optional($u->employeeProfile)->speciality ?? 'Employee');
                    @endphp

                    <div class="bg-white border border-[#e5e7eb] rounded-2xl p-5 text-center hover:shadow-soft transition">
                        <div class="w-20 h-20 rounded-full mx-auto bg-cover bg-center ring-4 ring-[#f6f7f8]"
                            style="background-image:url('{{ $avatar }}')"></div>
                        <h3 class="mt-4 font-extrabold text-[#111418]">{{ $u->name }}</h3>
                        <p class="text-xs font-bold text-[#617589] mt-1">{{ $title }}</p>

                        <a href="{{ route('users.show', $u) }}"
                            class="mt-4 h-10 w-full rounded-xl bg-primary text-white font-extrabold flex items-center justify-center hover:opacity-95">
                            View Profile
                        </a>

                        <a href="{{ route('conversation.affiche', $u->id) }}"
                            class="mt-4 h-10 w-full rounded-xl bg-primary text-white font-extrabold flex items-center justify-center hover:opacity-95">
                            Message
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-[#617589]">No friends yet.</p>
                @endforelse
            </div>
        @endif

        {{-- Pending --}}
        @if($tab === 'pending')
            <div class="bg-white border border-[#e5e7eb] rounded-2xl overflow-hidden">
                @forelse($pendingReceived as $req)
                    @php
                        $u = $req->sender;
                        $avatar = $u->avatar_path ? asset('storage/' . $u->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=137fec&color=ffffff&bold=true';
                        $title = $u->hasRole('recruiter')
                            ? (optional($u->recruiterProfile)->company_name ?? 'Recruiter')
                            : (optional(optional($u->employeeProfile)->speciality)->name ?? optional($u->employeeProfile)->speciality ?? 'Employee');
                    @endphp

                    <div
                        class="p-4 flex flex-wrap items-center justify-between gap-4 border-b border-[#e5e7eb] last:border-0 hover:bg-[#f8f9fb] transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-cover bg-center"
                                style="background-image:url('{{ $avatar }}')"></div>
                            <div>
                                <p class="text-sm font-extrabold text-[#111418]">{{ $u->name }}</p>
                                <p class="text-xs text-[#617589]">{{ $title }}</p>
                                <p class="text-[10px] text-primary font-bold mt-1">Sent {{ $req->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('connections.accept', $req) }}">
                                @csrf
                                <button
                                    class="px-4 py-2 bg-primary text-white text-xs font-extrabold rounded-xl">Accept</button>
                            </form>

                            <form method="POST" action="{{ route('connections.decline', $req) }}">
                                @csrf
                                <button
                                    class="px-4 py-2 bg-[#f0f2f4] text-[#111418] text-xs font-extrabold rounded-xl">Decline</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-sm text-[#617589]">No pending requests.</div>
                @endforelse
            </div>
        @endif

        {{-- Suggestions --}}
        @if($tab === 'suggestions')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($suggestions as $u)
                    @php
                        $avatar = $u->avatar_path ? asset('storage/' . $u->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=137fec&color=ffffff&bold=true';
                        $title = $u->hasRole('recruiter')
                            ? (optional($u->recruiterProfile)->company_name ?? 'Recruiter')
                            : (optional(optional($u->employeeProfile)->speciality)->name ?? optional($u->employeeProfile)->speciality ?? 'Employee');
                    @endphp

                    <div class="bg-white border border-[#e5e7eb] rounded-2xl p-4 text-center">
                        <div class="w-16 h-16 rounded-full mx-auto bg-cover bg-center"
                            style="background-image:url('{{ $avatar }}')"></div>
                        <h4 class="mt-3 text-sm font-extrabold text-[#111418]">{{ $u->name }}</h4>
                        <p class="text-[11px] text-[#617589] mb-1">{{ $title }}</p>
                        <a href="{{ route('users.show', $u) }}"
                            class="mb-3 inline-block text-sm font-semibold text-primary hover:underline">
                            Voir profil →
                        </a>
                        <form method="POST" action="{{ route('connections.request', $u) }}">
                            @csrf
                            <button
                                class="w-full py-2 border border-primary text-primary text-xs font-extrabold rounded-xl hover:bg-primary/5">
                                Connect
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-[#617589]">No suggestions.</p>
                @endforelse
            </div>
        @endif
    </div>
</x-app-layout>