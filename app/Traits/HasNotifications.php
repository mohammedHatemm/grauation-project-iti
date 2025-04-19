<?php

namespace App\Traits;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasNotifications
{
  public function customNotifications(): MorphMany
  {
    return $this->morphMany(Notification::class, 'notifiable');
  }

  public function customUnreadNotifications(): MorphMany
  {
    return $this->customNotifications()->whereNull('read_at');
  }

  public function customReadNotifications(): MorphMany
  {
    return $this->customNotifications()->whereNotNull('read_at');
  }

  public function customNotify(string $type, array $data): Notification
  {
    return app(\App\Services\NotificationService::class)->create($this, $type, $data);
  }

  public function markAllNotificationsAsRead(): void
  {
    app(\App\Services\NotificationService::class)->markAllAsRead($this);
  }

  public function getUnreadNotificationsCount(): int
  {
    return app(\App\Services\NotificationService::class)->getUnreadCount($this);
  }
}
