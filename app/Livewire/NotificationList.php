<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class NotificationList extends Component
{
  public Collection $notifications;
  public int $unreadCount = 0;

  public function mount(NotificationService $notificationService)
  {
    $this->notifications = collect();
    $this->loadNotifications($notificationService);
  }

  public function loadNotifications(NotificationService $notificationService)
  {
    if (Auth::check()) {
      $user = Auth::user();
      $this->notifications = $user->customNotifications()->latest()->take(5)->get();
      $this->unreadCount = $user->customUnreadNotifications()->count();
    }
  }

  public function markAsRead(string|int $notificationId, NotificationService $notificationService)
  {
    $notification = auth()->user()->customNotifications()->find($notificationId);
    if ($notification) {
      $notification->markAsRead();
      $this->loadNotifications($notificationService);
    }
  }

  public function markAllAsRead(NotificationService $notificationService)
  {
    auth()->user()->markAllNotificationsAsRead();
    $this->loadNotifications($notificationService);
  }
}
