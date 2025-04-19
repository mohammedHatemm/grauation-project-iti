<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Events\NotificationStatusChanged;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\Authenticatable;

class NotificationService
{
    /**
     * Create a new notification
     *
     * @param Model $notifiable
     * @param string $type
     * @param array $data
     * @return Notification
     * @throws \InvalidArgumentException
     */
    public function create(Model $notifiable, string $type, array $data): Notification
    {
        // Validate notification data
        $validator = Validator::make([
            'type' => $type,
            'data' => $data
        ], [
            'type' => 'required|string|max:255',
            'data' => 'required|array'
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        try {
            $notification = Notification::create([
                'type' => $type,
                'notifiable_type' => get_class($notifiable),
                'notifiable_id' => $notifiable->id,
                'data' => $data,
                'read_at' => null
            ]);

            event(new NotificationCreated($notification));
            return $notification;
        } catch (\Exception $e) {
            \Log::error('Failed to create notification: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mark a notification as read
     *
     * @param Notification|\Illuminate\Notifications\DatabaseNotification $notification
     * @return void
     * @throws \InvalidArgumentException
     */
    public function markAsRead($notification): void
    {
        if (!($notification instanceof Notification) &&
            !($notification instanceof \Illuminate\Notifications\DatabaseNotification)) {
            throw new \InvalidArgumentException('Invalid notification object');
        }

        try {
            $notification->forceFill(['read_at' => now()])->save();
            event(new NotificationStatusChanged($notification));
        } catch (\Exception $e) {
            \Log::error('Failed to mark notification as read: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mark all notifications as read for a user
     *
     * @param Authenticatable $notifiable
     * @return void
     */
    public function markAllAsRead(Authenticatable $notifiable): void
    {
        try {
            // More efficient batch update
            $notifiable->customNotifications()
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            // Fire event for real-time updates
            event(new NotificationStatusChanged([
                'notifiable_id' => $notifiable->id,
                'notifiable_type' => get_class($notifiable),
                'bulk_update' => true
            ]));
        } catch (\Exception $e) {
            \Log::error('Failed to mark all notifications as read: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get unread notification count
     *
     * @param Authenticatable $notifiable
     * @return int
     */
    public function getUnreadCount(Authenticatable $notifiable): int
    {
        try {
            return $notifiable->customNotifications()->whereNull('read_at')->count();
        } catch (\Exception $e) {
            \Log::error('Failed to get unread count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get notifications for a user
     *
     * @param Authenticatable $notifiable
     * @param bool $onlyUnread
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNotifications(Authenticatable $notifiable, bool $onlyUnread = false)
    {
        try {
            $query = $notifiable->customNotifications();

            if ($onlyUnread) {
                $query->whereNull('read_at');
            }

            return $query->latest()->get();
        } catch (\Exception $e) {
            \Log::error('Failed to get notifications: ' . $e->getMessage());
            return collect();
        }
    }
}
