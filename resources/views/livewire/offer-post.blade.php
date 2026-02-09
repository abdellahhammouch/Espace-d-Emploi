@php
    $recruiter = $offer->recruiter;

    $company = $recruiter?->recruiterProfile?->company_name
        ?? $recruiter?->name
        ?? 'Entreprise';

    $publisher = $recruiter?->name ?? 'Recruteur';

    $avatar = $recruiter?->avatar_path
        ? \Illuminate\Support\Facades\Storage::url($recruiter->avatar_path)
        : 'https://ui-avatars.com/api/?name='.urlencode($company).'&background=137fec&color=ffffff&bold=true';

    $imagePath = $offer->image_path ?? $offer->image_offer ?? null;
    $image = $imagePath ? \Illuminate\Support\Facades\Storage::url($imagePath) : null;
@endphp

<article class="bg-white rounded-2xl border border-[#e5e7eb] shadow-sm overflow-hidden">
    {{-- Header --}}
    <div class="p-5 flex items-start justify-between gap-4">
        <div class="flex gap-3 min-w-0">
            <div class="size-11 rounded-xl bg-cover bg-center border border-[#e5e7eb]"
                 style="background-image:url('{{ $avatar }}')"></div>

            <div class="min-w-0">
                <p class="font-extrabold text-[#111418] truncate">{{ $publisher }}</p>
                <p class="text-xs text-[#617589] truncate">
                    {{ $offer->place }} • {{ $offer->created_at?->diffForHumans() }}
                </p>
            </div>
        </div>

        <span class="shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
            {{ $offer->contractType?->name }}
        </span>
    </div>

    {{-- Content --}}
    <div class="px-5 pb-4 space-y-3">
        {{-- company + title on same line with space --}}
        <div class="flex items-baseline gap-2 flex-wrap">
            <h3 class="text-lg font-black text-primary">{{ $company }}</h3>
            <h3 class="text-lg font-black text-[#111418]">{{ $offer->title }}</h3>
        </div>

        <p class="text-sm text-[#111418] leading-relaxed whitespace-pre-line">
            {{ $offer->description }}
        </p>
    </div>

    {{-- Image --}}
    @if($image)
        <div class="border-y border-[#e5e7eb] bg-[#f6f7f8]">
            <img src="{{ $image }}" alt="Offer image" class="w-full max-h-[420px] object-cover">
        </div>
    @endif

    {{-- Actions --}}
    <div class="p-4 flex items-center justify-between gap-3">
        <div class="text-xs text-[#617589]">
            <span class="font-bold text-[#111418]">{{ $likesCount }}</span> likes
        </div>

        <div class="flex gap-2">
            {{-- Like without refresh --}}
            <button type="button"
                    wire:click="toggleLike"
                    wire:loading.attr="disabled"
                    class="h-11 px-4 rounded-xl border border-[#e5e7eb] font-extrabold flex items-center gap-2
                           hover:bg-[#f0f2f4] transition
                           {{ $likedByMe ? 'text-primary border-primary/30 bg-primary/5' : 'text-[#111418]' }}">
                <span class="material-symbols-outlined text-[20px]">thumb_up</span>
                {{ $likedByMe ? 'Liked' : 'Like' }}
            </button>

            {{-- Apply (garde ton form normal pour l’instant) --}}
            <form method="POST" action="{{ route('offers.apply', $offer) }}">
                @csrf
                <button type="submit"
                        class="h-11 px-5 rounded-xl bg-primary text-white font-extrabold hover:opacity-95 transition">
                    Postuler
                </button>
            </form>
        </div>
    </div>
</article>
