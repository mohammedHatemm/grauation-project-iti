<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Events\RefreshNotificationsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RefreshNotifications
{
    /**
     * Handle the event.
     */
    public function handle(NotificationCreated $event): void
    {
        // Extract the user ID from the notification and pass it to the event
        $userId = $event->notification->notifiable_id;

        broadcast(new RefreshNotificationsEvent($userId));
    }
}
