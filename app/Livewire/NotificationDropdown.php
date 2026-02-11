<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public bool $open = false;
    public $notifications;
    public int $unreadCount = 0;

    public function mount()
    {
        $this->notifications = collect();
        $this->loadNotifications();
    }

    public function toggle()
    {
        $this->open = ! $this->open;
        if ($this->open) {
            $this->loadNotifications();
        }
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()
            ->notifications()
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(10)
            ->get();

        $this->unreadCount = Auth::user()
            ->unreadNotifications()
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
    }

    public function markAsRead(string $id)
    {
        Auth::user()
            ->notifications()
            ->where('id', $id)
            ->first()
            ?->markAsRead();

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-dropdown');
    }
}
