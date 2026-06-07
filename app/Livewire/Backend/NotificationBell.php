<?php

namespace App\Livewire\Backend;

use App\Models\SystemNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Poll;
use Livewire\Component;

class NotificationBell extends Component
{
    public int $unreadCount = 0;

    /** @var Collection<int, SystemNotification> */
    public Collection $notifications;

    public function mount(): void
    {
        $this->notifications = new Collection;
    }

    public function loadNotifications(): void
    {
        $this->notifications = SystemNotification::where('user_id', Auth::id())
            ->latest()
            ->limit(15)
            ->get();
    }

    public function markAllRead(): void
    {
        SystemNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->loadNotifications();
    }

    public function markRead(int $id): void
    {
        SystemNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['read_at' => now()]);

        $this->loadNotifications();
    }

    #[Poll(60000)]
    public function render(): View
    {
        $this->unreadCount = SystemNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return view('livewire.backend.notification-bell');
    }
}
