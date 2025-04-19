<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Livewire\WithPagination;

class NotificationList extends Component
{
    use WithPagination;

    public Collection $notifications;
    public int $unreadCount = 0;
    public int $perPage = 5;
    public bool $isLoading = false;
    public ?string $error = null;

    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function mount()
    {
        $this->notifications = collect();
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (!Auth::check()) {
            $this->notifications = collect();
            $this->unreadCount = 0;
            return;
        }

        $this->isLoading = true;

        try {
            $user = Auth::user();
            $this->notifications = $this->notificationService->getNotifications($user)->take($this->perPage);
            $this->unreadCount = $this->notificationService->getUnreadCount($user);
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = 'Failed to load notifications';
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to load notifications'
            ]);
        } finally {
            $this->isLoading = false;
        }
    }

    public function loadMore()
    {
        $this->perPage += 5;
        $this->loadNotifications();
    }

    public function markAsRead(string|int $notificationId)
    {
        if (!Auth::check()) {
            return;
        }

        try {
            $notification = auth()->user()->customNotifications()->find($notificationId);
            if ($notification) {
                $this->notificationService->markAsRead($notification);
                $this->loadNotifications();
                $this->dispatch('notificationStatusChanged');
            }
        } catch (\Exception $e) {
            $this->error = 'Failed to mark notification as read';
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to mark notification as read'
            ]);
        }
    }

    public function markAllAsRead()
    {
        if (!Auth::check()) {
            return;
        }

        try {
            $this->notificationService->markAllAsRead(auth()->user());
            $this->loadNotifications();
            $this->dispatch('notificationStatusChanged');
        } catch (\Exception $e) {
            $this->error = 'Failed to mark all notifications as read';
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to mark all notifications as read'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.notification-list');
    }

    public function getListeners()
    {
        if (!Auth::check()) {
            return [];
        }

        return [
            'echo:private-notifications.' . auth()->id() . ',NotificationCreated' => 'loadNotifications',
            'echo:private-notifications.' . auth()->id() . ',NotificationStatusChanged' => 'loadNotifications',
            'refreshNotifications' => 'loadNotifications'
        ];
    }
}
