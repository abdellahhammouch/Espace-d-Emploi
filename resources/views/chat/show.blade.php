<x-app-layout>
    <div class="h-screen bg-slate-100/50">
        <div class="max-w-7xl mx-auto h-full px-4 py-6">
            <div class="grid grid-cols-12 gap-6 h-[calc(100vh-100px)]">

                <aside class="col-span-4 lg:col-span-3 h-full">
                    <div class="h-full bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                        <div class="p-5 border-b border-slate-100">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Messages</h2>
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20">
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-3 space-y-1">
                            @foreach($friends as $friend)
                            <a href="{{ route('conversation.affiche', $friend->friend_id) }}" class="flex items-center gap-3 p-3 rounded-2xl transition-all hover:bg-slate-50">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-500 text-white flex items-center justify-center font-bold shadow-md"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-slate-700 truncate">{{$friend->friend->name}}</p>
                                    <p class="text-xs text-slate-500 truncate">Online</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <main class="col-span-8 lg:col-span-9 h-full">
                    <div class="h-full bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden flex flex-col">
                        
                        <div class="px-6 py-4 border-b border-slate-100 bg-white/80">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($activeFriend->name ?? $receiver->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-black text-slate-800 text-lg leading-none mb-1">{{ $activeFriend->name ?? $receiver->name ?? 'Chat' }}</p>
                                    <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Active Now</p>
                                </div>
                            </div>
                        </div>

                        <div id="messages-container" class="flex-1 overflow-y-auto px-6 py-8 bg-slate-50/50" style="scrollbar-width: none;">
                            <div class="space-y-6 h-3">
                                @foreach($messages as $message)
                                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[75%]">
                                            <div class="px-5 py-3 rounded-2xl shadow-sm {{ $message->sender_id === auth()->id() ? 'bg-indigo-700 text-white rounded-tr-none' : 'bg-indigo-200 text-slate-700 border border-slate-100 rounded-bl-none' }}">
                                                <p class="text-sm leading-relaxed">{{ $message->content }}</p>
                                                
                                                {{-- Logical placeholder for file display --}}
                                                @if(isset($message->file_path))
                                                    <div class="mt-2 p-2 rounded-lg bg-black/10 border border-white/20 flex items-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                        <span class="text-xs truncate max-w-[150px]">File Attachment</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase text-right">{{ $message->created_at->format('H:i') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-4 bg-white border-t border-slate-100">
                            {{-- Added enctype for file uploads --}}
                            <form action="{{ route('message.send') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $activeFriend->id ?? $receiver->id }}">
                                
                                {{-- Selection Preview (Hidden by default) --}}
                                <div id="file-preview" class="hidden items-center gap-2 p-2 bg-indigo-50 rounded-xl border border-indigo-100">
                                    <span class="text-xs font-bold text-indigo-600 px-2" id="file-name"></span>
                                    <button type="button" onclick="clearFile()" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>

                                <div class="flex items-center gap-3 bg-slate-50 p-2 rounded-3xl border border-slate-200 focus-within:border-indigo-400 transition-all">
                                    <button type="button" onclick="document.getElementById('file-input').click()" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors bg-white rounded-full shadow-sm border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    </button>
                                    
                                    <input type="file" name="attachment" id="file-input" class="hidden" onchange="handleFileSelect(this)">

                                    <input type="text" name="content" placeholder="Write a message..." 
                                        class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-2 text-slate-700" required>

                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-indigo-200">
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

    <script>
        // Auto-scroll to bottom
        const container = document.getElementById('messages-container');
        if (container) container.scrollTop = container.scrollHeight;

        // File handling logic
        function handleFileSelect(input) {
            const preview = document.getElementById('file-preview');
            const nameSpan = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                nameSpan.innerText = "📎 " + input.files[0].name;
                preview.classList.remove('hidden');
                preview.classList.add('flex');
            }
        }

        function clearFile() {
            const input = document.getElementById('file-input');
            const preview = document.getElementById('file-preview');
            input.value = '';
            preview.classList.add('hidden');
            preview.classList.remove('flex');
        }
    </script>
</x-app-layout>