<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-[600px] flex flex-col">
                
                <div class="bg-blue-600 p-4 text-white font-bold text-lg flex items-center shadow-md">
                   <span>Discussion m3a User #{{ $receiverId }}</span>
                </div>

                <div class="flex-1 p-4 overflow-y-auto bg-gray-50 space-y-4" id="messages-container">
                    
                    @foreach($messages as $message)
                        
                        {{-- Check: Wach ana li sift had l-message? --}}
                        @if($message->sender_id == auth()->id())
                            
                            <div class="flex justify-end">
                                <div class="bg-blue-500 text-white max-w-[70%] rounded-l-lg rounded-br-lg p-3 shadow">
                                    <p class="text-sm">{{ $message->content }}</p>
                                    <span class="text-xs text-blue-100 block text-right mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>

                        @else

                            <div class="flex justify-start">
                                <div class="bg-white text-gray-800 max-w-[70%] rounded-r-lg rounded-bl-lg p-3 shadow border border-gray-200">
                                    <p class="text-sm">{{ $message->content }}</p>
                                    <span class="text-xs text-gray-500 block text-left mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>

                        @endif

                    @endforeach

                </div>

                <div class="p-4 bg-gray-100 border-t border-gray-200">
                    <form action="#" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" 
                               name="content" 
                               class="flex-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Kteb message..." 
                               required>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                            Sift
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    </script>
</x-app-layout>