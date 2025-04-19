<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Models\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{

  public function create(Model $notifiable, string $type, array $data): Notification
  {
    $notification = Notification::create([
      'type' => $type,
      'notifiable_type' => get_class($notifiable),
      'notifiable_id' => $notifiable->id,
      'data' => $data
    ]);

    event(new NotificationCreated($notification));
    return $notification;
  }

  public function markAsRead($notification): void
  {
    if ($notification instanceof Notification || $notification instanceof \Illuminate\Notifications\DatabaseNotification) {
      $notification->forceFill(['read_at' => now()])->save();
      event(new NotificationCreated($notification));
    }
  }

  public function markAllAsRead(\Illuminate\Contracts\Auth\Authenticatable $notifiable): void
  {
    $notifications = $notifiable->customNotifications()
      ->whereNull('read_at')
      ->get();

    foreach ($notifications as $notification) {
      $notification->forceFill(['read_at' => now()])->save();
      event(new NotificationCreated($notification));
    }
  }

  public function getUnreadCount(\Illuminate\Contracts\Auth\Authenticatable $notifiable): int
  {
    return $notifiable->customNotifications()
      ->whereNull('read_at')
      ->count();
  }

  public function getNotifications(\Illuminate\Contracts\Auth\Authenticatable $notifiable, bool $onlyUnread = false)
  {
    $query = $notifiable->customNotifications();

    if ($onlyUnread) {
      $query->whereNull('read_at');
    }

    return $query->latest()->get();
  }
}
