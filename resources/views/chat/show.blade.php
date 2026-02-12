<x-app-layout>
    <div class="h-screen bg-slate-100/50">
        <div class="max-w-7xl mx-auto h-full px-4 py-6">
            <div class="grid grid-cols-12 gap-6 h-[calc(100vh-100px)]">

                {{-- ASIDE (B9a kif ma howa) --}}
                <aside class="col-span-4 lg:col-span-3 h-full">
                    <div
                        class="h-full bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                        <div class="p-5 border-b border-slate-100">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Messages</h2>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-3 space-y-1">
                            @foreach($friends as $friend)

                                <a href="#"
                                    class="flex items-center gap-3 p-3 rounded-2xl transition-all hover:bg-slate-50">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-indigo-500 text-white flex items-center justify-center font-bold shadow-md">
                                        {{ strtoupper(substr($friend->friend->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-slate-700 truncate">{{$friend->friend->name}}</p>
                                        <p class="text-xs text-slate-500 truncate">Online</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                {{-- MAIN CHAT AREA --}}
                <main class="col-span-8 lg:col-span-9 h-full">
                    <div
                        class="h-full bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden flex flex-col">

                        {{-- Header --}}
                        <div class="px-6 py-4 border-b border-slate-100 bg-white/80">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($activeFriend->name ?? $receiver->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-black text-slate-800 text-lg leading-none mb-1">
                                        {{ $activeFriend->name ?? $receiver->name ?? 'Chat' }}</p>
                                    <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Active Now</p>
                                </div>
                            </div>
                        </div>

                        {{-- MESSAGES CONTAINER --}}
                        @php
                            // dd($messages);
                        @endphp
                        <div id="messages-container" class="flex-1 overflow-y-auto px-6 py-8 bg-slate-50/50"
                            style="scrollbar-width: none;">
                            <div class="space-y-6">
                                @foreach($messages as $message)
                                    <div
                                        class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[75%]">
                                            <div
                                                class="px-5 py-3 rounded-2xl shadow-sm {{ $message->sender_id === auth()->id() ? 'bg-indigo-700 text-white rounded-tr-none' : 'bg-indigo-200 text-slate-700 border border-slate-100 rounded-bl-none' }}">



                                                {{-- MEDIA DISPLAY LOGIC --}}
                                                @if($message->file_path)
                                                    <div class="mt-2">

                                                        {{-- CASE 1: IMAGE --}}
                                                        @if($message->type === 'image')
                                                            <div class="relative group">
                                                                <img src="{{ asset('storage/attachment/' . $message->file_path) }}"
                                                                    alt="Attachment"
                                                                    class="rounded-xl max-h-64 object-cover border-2 border-white/20 shadow-sm cursor-pointer hover:opacity-90 transition-opacity">
                                                            </div>

                                                            {{-- CASE 2: VIDEO --}}
                                                        @elseif($message->type === 'video')
                                                            <div
                                                                class="rounded-xl overflow-hidden border-2 border-white/20 shadow-sm bg-black">
                                                                <video controls class="max-h-64 w-full">
                                                                    <source src="{{ asset('storage/' . $message->file_path) }}">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </div>

                                                            {{-- CASE 3: FILE (PDF, DOCS, ETC) --}}
                                                        @else
                                                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank"
                                                                download
                                                                class="flex items-center gap-3 p-3 rounded-xl bg-black/10 hover:bg-black/20 transition-colors border border-white/20 group">
                                                                <div
                                                                    class="p-2 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                                <div class="flex-1 min-w-0">
                                                                    <p class="text-xs font-bold truncate">Attachment</p>
                                                                    <p class="text-[10px] opacity-70">Click to download</p>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif

                                                {{-- Text Content --}}
                                                @if($message->content)
                                                    <p class="text-sm leading-relaxed mb-2">{{ $message->content }}</p>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase text-right">
                                                {{ $message->created_at->format('H:i') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- INPUT AREA --}}
                        <div class="p-4 bg-white border-t border-slate-100">
                            <form action="{{ route('message.send') }}" method="POST" enctype="multipart/form-data"
                                class="flex flex-col gap-2">
                                @csrf
                                <input type="hidden" name="receiver_id"
                                    value="{{ $activeFriend->id ?? $receiver->id }}">

                                {{-- File Preview Area --}}
                                <div id="file-preview"
                                    class="hidden items-center gap-2 p-3 bg-indigo-50 rounded-2xl border border-indigo-100 mx-1">
                                    <div
                                        class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-indigo-700 px-2 truncate max-w-xs"
                                        id="file-name"></span>
                                    <button type="button" onclick="clearFile()"
                                        class="ml-auto p-1 text-slate-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div
                                    class="flex items-center gap-3 bg-slate-50 p-2 rounded-3xl border border-slate-200 focus-within:border-indigo-400 transition-all focus-within:ring-4 focus-within:ring-indigo-100">
                                    <button type="button" onclick="document.getElementById('file-input').click()"
                                        class="p-3 text-slate-400 hover:text-indigo-600 hover:bg-white transition-all rounded-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                    </button>

                                    <input type="file" name="attachment" id="file-input" class="hidden"
                                        onchange="handleFileSelect(this)">

                                    <input type="text" name="content" placeholder="Type your message..."
                                        class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-3 text-slate-700 placeholder-slate-400"
                                        autocomplete="off">

                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-indigo-200 hover:shadow-indigo-300 active:scale-95">
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>

    <div id="userID" data-id="{{ auth()->id() }}"></div>
    <div id="receiverID" data-id="{{ $receiver->id }}"></div>

    <script>
        // Auto-scroll to bottom
        const container = document.getElementById('messages-container');
        if (container) container.scrollTop = container.scrollHeight;

        function handleFileSelect(input) {
            const preview = document.getElementById('file-preview');
            const nameSpan = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                nameSpan.innerText = input.files[0].name;
                preview.classList.remove('hidden');
                preview.classList.add('flex');
            }
        }

        function clearFile() {
            const input = document.getElementById('file-input');
            const preview = document.getElementById('file-preview');
            input.value = ''; // Clear file input
            preview.classList.add('hidden');
            preview.classList.remove('flex');
        }
    </script>
</x-app-layout>