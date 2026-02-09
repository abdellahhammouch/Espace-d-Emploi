<x-recruitconnect-layout>
    @php
        $avatar = $user->avatar_path ? asset('storage/'.$user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=137fec&color=ffffff&bold=true';

        $isRecruiter = $user->hasRole('recruiter');

        $headline = $isRecruiter
            ? (optional($user->recruiterProfile)->company_name ?? 'Recruiter')
            : (optional(optional($user->employeeProfile)->speciality)->name ?? optional($user->employeeProfile)->speciality ?? 'Job Seeker');

        $location = $isRecruiter
            ? (optional($user->recruiterProfile)->location ?? null)
            : (optional($user->employeeProfile)->location ?? null);

        $experiences = optional($user->employeeProfile)->experiences ?? collect();
        $educations  = optional($user->employeeProfile)->educations ?? collect();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-[#e5e7eb] p-6 text-center">
                <div class="w-32 h-32 rounded-full mx-auto bg-cover bg-center ring-4 ring-primary/10" style="background-image:url('{{ $avatar }}')"></div>
                <h1 class="mt-4 text-2xl font-black text-[#111418]">{{ $user->name }}</h1>
                <p class="text-primary font-extrabold mt-1">{{ $headline }}</p>

                @if($location)
                    <p class="text-[#617589] text-sm mt-2 flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-base">location_on</span>
                        {{ $location }}
                    </p>
                @endif

                <div class="space-y-3">
                    @if($relation === 'self')
                        <a href="{{ route('profile.edit') }}"
                           class="h-11 w-full rounded-xl bg-primary text-white font-extrabold flex items-center justify-center hover:opacity-95">
                            Modifier mon profil
                        </a>

                    @elseif($relation === 'connected')
                        <button disabled
                                class="h-11 w-full rounded-xl bg-[#f0f2f4] text-[#617589] font-extrabold cursor-not-allowed">
                                Connected
                        </button>

                    @elseif($relation === 'pending')
                        <button disabled
                            class="h-11 w-full rounded-xl bg-[#f0f2f4] text-[#617589] font-extrabold cursor-not-allowed">
                            Pending
                        </button>

                    @elseif($relation === 'incoming')
                        <div class="grid grid-cols-2 gap-2">
                            <form method="POST" action="{{ route('connections.accept', $incomingRequest) }}">
                                @csrf
                                <button class="h-11 w-full rounded-xl bg-primary text-white font-extrabold    hover:opacity-95">
                                    Accepter
                                </button>
                            </form>

                            <form method="POST" action="{{ route('connections.decline', $incomingRequest) }}">
                                @csrf
                                <button class="h-11 w-full rounded-xl border border-[#e5e7eb] bg-white
                                    text-[#111418] font-extrabold hover:bg-[#f0f2f4]">
                                    Refuser
                                </button>
                            </form>
                        </div>

                    @else
                        <form method="POST" action="{{ route('connections.request', $user) }}">
                            @csrf
                            <button class="h-11 w-full rounded-xl bg-primary text-white font-extrabold
                                hover:opacity-95">
                                Connect
                            </button>
                        </form>
                    @endif

                    {{-- Tu peux garder Find similar si tu veux --}}
                    <a href="{{ route('search.index', ['q' => $user->name]) }}"
                       class="h-11 w-full rounded-xl bg-[#f0f2f4] text-[#111418] font-extrabold flex items-center justify-center hover:bg-[#e7eaee]">
                        <span class="material-symbols-outlined mr-2">search</span>
                        Find similar
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-[#e5e7eb] p-6">
                <h3 class="text-xs font-black uppercase tracking-wider text-[#617589] mb-4">Information</h3>

                <div class="space-y-4 text-sm">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">mail</span>
                        <span class="text-[#111418]">{{ $user->email }}</span>
                    </div>

                    @if($isRecruiter && optional($user->recruiterProfile)->website)
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">link</span>
                            <span class="text-[#111418]">{{ $user->recruiterProfile->website }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right --}}
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-2xl border border-[#e5e7eb] p-6">
                <h2 class="text-xl font-black text-[#111418] flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-primary">person</span>
                    About
                </h2>
                <p class="text-[#111418] leading-relaxed">
                    {{ $user->bio ?: 'No bio yet.' }}
                </p>
            </div>

            @if(!$isRecruiter)
                <div class="bg-white rounded-2xl border border-[#e5e7eb] p-6">
                    <h2 class="text-xl font-black text-[#111418] flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-primary">work</span>
                        Experiences
                    </h2>

                    @forelse($experiences as $exp)
                        <div class="pb-5 mb-5 border-b border-[#f0f2f4] last:border-0 last:pb-0 last:mb-0">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <p class="font-extrabold text-[#111418]">{{ $exp->title }}</p>
                                    <p class="text-primary font-bold text-sm">{{ $exp->company }}</p>
                                </div>
                                <span class="text-xs font-bold bg-[#f0f2f4] px-3 py-1 rounded-full text-[#617589]">
                                    {{ $exp->date_start }} → {{ $exp->date_end ?? 'Present' }}
                                </span>
                            </div>
                            @if($exp->description)
                                <p class="text-sm text-[#617589] mt-2">{{ $exp->description }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-[#617589]">No experiences added.</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-2xl border border-[#e5e7eb] p-6">
                    <h2 class="text-xl font-black text-[#111418] flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-primary">school</span>
                        Education
                    </h2>

                    @forelse($educations as $edu)
                        <div class="pb-5 mb-5 border-b border-[#f0f2f4] last:border-0 last:pb-0 last:mb-0">
                            <p class="font-extrabold text-[#111418]">{{ $edu->degree }}</p>
                            <p class="text-sm text-[#617589]">{{ $edu->school }}</p>
                            <p class="text-xs text-[#617589] mt-1">Year: {{ $edu->year ?? '—' }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-[#617589]">No education added.</p>
                    @endforelse
                </div>
            @else
                <div class="bg-white rounded-2xl border border-[#e5e7eb] p-6">
                    <h2 class="text-xl font-black text-[#111418] flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-primary">business</span>
                        Company
                    </h2>
                    <p class="text-sm text-[#617589]">
                        {{ optional($user->recruiterProfile)->company_name ?? '—' }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-recruitconnect-layout>
