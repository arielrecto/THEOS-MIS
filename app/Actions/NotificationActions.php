<?php

namespace App\Actions;

use App\Models\User;
use App\Models\NotificationLog;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class NotificationActions
{
    /**
     * Create a notification log
     */
    public function create(User $user, array $data, ?Model $notifiable = null): NotificationLog
    {
        return NotificationLog::create([
            'user_id' => $user->id,
            'header' => $data['header'] ?? 'System Notification',
            'message' => $data['message'],
            'type' => $data['type'] ?? 'info',
            'is_read' => false,
            'url' => $data['url'] ?? null,
            'notifiable_id' => $notifiable?->id,
            'notifiable_type' => $notifiable ? get_class($notifiable) : null,
        ]);
    }

    /**
     * Send notification to specific users
     */
    public function notifyUsers(Collection $users, array $data, ?Model $notifiable = null): void
    {
        $users->each(fn($user) => $this->create($user, $data, $notifiable));
    }

    /**
     * Send notification to users with specific role
     */
    public function notifyRole(string $role, array $data, ?Model $notifiable = null): void
    {
        $users = User::role($role)->get();
        $this->notifyUsers($users, $data, $notifiable);
    }

    /**
     * Send notification to users with multiple roles
     */
    public function notifyRoles(array $roles, array $data, ?Model $notifiable = null): void
    {
        $users = User::whereHas('roles', function($query) use ($roles) {
            $query->whereIn('name', $roles);
        })->get();

        $this->notifyUsers($users, $data, $notifiable);
    }

    /**
     * Send notification to all users
     */
    public function notifyAll(array $data, ?Model $notifiable = null): void
    {
        $this->notifyUsers(User::all(), $data, $notifiable);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(NotificationLog $notification): void
    {
        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead(User $user): void
    {
        $user->notificationLogs()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }

    /**
     * Delete notification
     */
    public function delete(NotificationLog $notification): void
    {
        $notification->delete();
    }

    /**
     * Clear all notifications for a user
     */
    public function clearAll(User $user): void
    {
        $user->notificationLogs()->delete();
    }

    /**
     * Get unread notifications for a user
     */
    public function getUnread(User $user): Collection
    {
        return $user->notificationLogs()
            ->where('is_read', false)
            ->latest()
            ->get();
    }

    /**
     * Get recent notifications for a user
     */
    public function getRecent(User $user, int $limit = 5): Collection
    {
        return $user->notificationLogs()
            ->latest()
            ->take($limit)
            ->get();
    }
}
