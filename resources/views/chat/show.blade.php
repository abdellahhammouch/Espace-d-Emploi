<x-app-layout>
    <div class="h-[calc(100vh-0px)]">
        <div class="h-screen bg-slate-50">
            <div class="h-full max-w-7xl mx-auto px-4 py-6">
                <div class="h-full grid grid-cols-12 gap-4">

                    <!-- SIDEBAR (Friends) -->
                    <aside class="col-span-4 lg:col-span-3 h-full">
                        <div
                            class="h-full bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">

                            <!-- Sidebar header -->
                            <div class="p-4 border-b">
                                <div class="flex items-center justify-between">
                                    <h2 class="font-bold text-slate-900">Messages</h2>
                                    <button type="button"
                                        class="h-10 w-10 rounded-2xl hover:bg-slate-100 grid place-items-center transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Search -->
                                <div class="mt-3">
                                    <input type="text" placeholder="Search friend..."
                                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5">
                                </div>
                            </div>

                            <!-- Friends list -->
                            <div class="flex-1 overflow-y-auto p-2">
                                <a href="#"
                                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-50 transition
                                       {{ isset($activeFriend) && $activeFriend->id === $friend->id ? 'bg-indigo-50 ring-1 ring-indigo-100' : '' }}">

                                    <!-- Avatar -->
                                    <div
                                        class="w-8 h-8 rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white grid place-items-center font-bold">
                                        <!-- {{ strtoupper(substr($friend->name ?? 'U', 0, 1)) }} -->GX
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-slate-900 truncate">aaaa</p>
                                        <p class="text-xs text-slate-500 truncate">
                                            {{-- optional: last message snippet --}}
                                            Tap to open chat
                                        </p>
                                    </div>

                                    <div class="text-[11px] text-slate-400">
                                        {{-- optional time --}}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </aside>

                    <!-- MAIN CHAT -->
                    <main class="col-span-8 lg:col-span-9 h-full">
                        <div
                            class="h-full bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">

                            <!-- Chat header -->
                            <div class="px-5 py-4 border-b bg-white">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white grid place-items-center font-bold">
                                        {{ strtoupper(substr($activeFriend->name ?? $receiver->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-slate-900">
                                            {{ $activeFriend->name ?? $receiver->name ?? 'Select a friend' }}
                                        </p>
                                        <p class="text-xs text-slate-500">Active</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages -->
                            <div id="messages-container" class="flex-1 overflow-y-auto px-5 py-5 bg-slate-50">
                                <div class="space-y-3">
                                    @foreach($messages as $message)
                                        @if($message->sender_id === auth()->id())
                                            <!-- My message -->
                                            <div class="flex justify-end">
                                                <div class="max-w-[70%]">
                                                    <div
                                                        class="bg-white text-slate-900 px-4 py-2.5 rounded-3xl rounded-br-sm shadow-sm border border-slate-200">
                                                        <p class="text-sm break-words leading-relaxed">{{ $message->content }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-1 text-[11px] text-slate-500 text-right">
                                                        {{ $message->created_at->format('H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Friend message -->
                                            <div class="flex justify-start">
                                                <div class="max-w-[70%]">
                                                    <div
                                                        class="bg-gradient-to-br from-indigo-600 to-blue-600 text-white px-4 py-2.5 rounded-3xl rounded-bl-sm shadow-sm">
                                                        <p class="text-sm break-words leading-relaxed">{{ $message->content }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-1 text-[11px] text-slate-500">
                                                        {{ $message->created_at->format('H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Input -->
                            <div class="border-t bg-white px-4 py-3">
                                <form action="{{ route('message.send') }}" method="POST"
                                    class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="receiver_id"
                                        value="{{ $activeFriend->id ?? $receiver->id }}">

                                    <input type="text" name="content" placeholder="Write a message..."
                                        class="flex-1 rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3"
                                        required>

                                    <button type="submit"
                                        class="h-12 px-5 rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold shadow-lg shadow-blue-600/20 transition">
                                        Send
                                    </button>
                                </form>
                            </div>

                        </div>
                    </main>

                </div>
            </div>
        </div>
    </div>

    <div id="userID" data-id="{{ auth()->id() }}"></div>
    <div id="receiverID" data-id="{{ $receiver->id }}"></div>

    <script>
        const container = document.getElementById('messages-container');
        if (container) container.scrollTop = container.scrollHeight;
    </script>
</x-app-layout>