<x-recruitconnect-layout>
    <div class="space-y-8">
        <div class="space-y-3">
            <h1 class="text-3xl md:text-4xl font-black tracking-tight text-[#111418]">Search Results</h1>
            <p class="text-[#617589]">Find and connect with professionals</p>
        </div>

        <form method="GET" action="{{ route('users.search') }}" class="w-full">
            <div class="relative flex items-center h-14 bg-white rounded-2xl border border-[#e5e7eb]">
                <span class="material-symbols-outlined absolute left-5 text-[#617589] text-[28px]">search</span>
                <input name="q" value="{{ $q }}" class="w-full h-full pl-14 pr-32 rounded-2xl text-lg bg-transparent border-none focus:ring-2 focus:ring-primary/30 placeholder:text-[#617589]" placeholder="Search by name, specialty, or company...">
                <button class="absolute right-3 bg-primary text-white px-6 py-2 rounded-xl font-extrabold hover:opacity-95">Search</button>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($users as $u)
                @php
                    $avatar = $u->avatar_path ? asset('storage/'.$u->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=137fec&color=ffffff&bold=true';
                    $title = $u->hasRole('recruiter')
                        ? (optional($u->recruiterProfile)->company_name ?? 'Recruiter')
                        : (optional(optional($u->employeeProfile)->speciality)->name ?? optional($u->employeeProfile)->speciality ?? 'Employee');
                @endphp

                <div class="bg-white rounded-2xl border border-[#e5e7eb] p-5 flex flex-col items-center text-center hover:shadow-soft transition">
                    <div class="size-24 rounded-full bg-cover bg-center mb-4 ring-4 ring-[#f6f7f8]" style="background-image:url('{{ $avatar }}')"></div>
                    <h3 class="text-lg font-extrabold text-[#111418]">{{ $u->name }}</h3>
                    <p class="text-primary text-sm font-extrabold mb-2">{{ $title }}</p>
                    <p class="text-[#617589] text-sm leading-relaxed mb-5 line-clamp-2">{{ $u->bio ?? '—' }}</p>

                    <a href="{{ route('users.show', $u) }}" class="w-full mt-auto py-2.5 border border-[#e5e7eb] rounded-xl font-extrabold hover:border-primary/30">
                        View Profile
                    </a>
                </div>
            @empty
                <div class="text-sm text-[#617589]">Type something to search.</div>
            @endforelse
        </div>
    </div>
</x-recruitconnect-layout>
