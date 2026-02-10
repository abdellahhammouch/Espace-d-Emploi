<x-app-layout>
    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4">

            <div class="bg-white shadow-lg rounded-xl h-[650px] flex flex-col overflow-hidden">

                <!-- Header -->
                <div class="bg-blue-600 text-gray-800 px-6 py-4 font-semibold text-lg flex items-center">
                    Discussion with {{ $receiver->name }}
                </div>

                <!-- Messages -->
                <div id="messages-container" class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-gray-100">

                    @foreach($messages as $message)

                        @if($message->sender_id === auth()->id())

                            <!-- My message -->
                            <div class="flex justify-end">
                                <div
                                    class="bg-white text-gray-800 max-w-[65%] px-4 py-2 rounded-2xl rounded-bl-sm shadow border">
                                    <p class="text-sm break-words">{{ $message->content }}</p>
                                    <span class="text-[11px] text-gray-500 block mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>

                        @else

                            <!-- Receiver message -->
                            <div class="flex justify-start">
                                <div
                                    class="bg-white text-gray-800 max-w-[65%] px-4 py-2 rounded-2xl rounded-bl-sm shadow border">
                                    <p class="text-sm break-words">{{ $message->content }}</p>
                                    <span class="text-[11px] text-gray-500 block mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>

                        @endif

                    @endforeach

                </div>

                <!-- Input -->
                <div class="border-t px-4 py-3">
                    <form action="{{ route('message.send') }}" method="POST" class="flex gap-3">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

                        <input type="text" name="content" placeholder="Write your message..."
                            class="flex-1 rounded-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4"
                            required>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-full font-medium transition">
                            Send
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="userID" data-id="{{ auth()->id() }}"></div>
    <div id="receiverID" data-id="{{ $receiver->id }}"></div>


</x-app-layout>