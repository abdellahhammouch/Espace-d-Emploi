<div wire:poll.5s="loadNotifications" class="relative">
    <!-- Notification Button -->
    <button wire:click="toggle" class="relative">
        🔔
        @if($unreadCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    @if($open)
        <div class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg z-50">
            <div class="p-3 font-bold border-b">
                Notifications
            </div>

            @forelse($notifications as $notification)
                <div class="p-3 border-b hover:bg-gray-100
                    {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                    
                    <a href="{{ $notification->data['url'] ?? '#' }}"
                       wire:click="markAsRead('{{ $notification->id }}')"
                       class="block">

                        <div class="text-sm font-semibold">
                            {{ $notification->data['place'] }}
                        </div>

                        <div class="text-xs text-gray-600">
                            {{ $notification->data['title'] }}
                        </div>

                        <div class="text-xs text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </a>
                </div>
            @empty
                <div class="p-3 text-center text-gray-500">
                    No notifications
                </div>
            @endforelse
        </div>
    @endif
</div>
