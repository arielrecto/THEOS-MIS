<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NotificationLog;
use App\Actions\NotificationActions;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationActions;

    public function __construct(NotificationActions $notificationActions)
    {
        $this->notificationActions = $notificationActions;
    }

    public function index()
    {
        $query =  User::find(Auth::user()->id)->notificationLogs();

        if (request('filter') === 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query->latest()->paginate(15);
        $unreadCount = User::find(Auth::user()->id)->getUnreadNotificationsCountAttribute();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(NotificationLog $notification)
    {
        $this->notificationActions->markAsRead($notification);
        return back()->with('success', 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        $this->notificationActions->markAllAsRead(Auth::user());
        return back()->with('success', 'All notifications marked as read');
    }

    public function destroy(NotificationLog $notification)
    {
        $this->notificationActions->delete($notification);
        return back()->with('success', 'Notification deleted');
    }

    public function clearAll()
    {
        $this->notificationActions->clearAll(Auth::user());
        return back()->with('success', 'All notifications cleared');
    }

    public function show(NotificationLog $notification)
    {
        // Mark notification as read when viewed
        if (!$notification->is_read) {
            $this->notificationActions->markAsRead($notification);
        }

        // Get related content if available
        $relatedContent = null;
        if ($notification->notifiable_id && $notification->notifiable_type) {
            $relatedContent = $notification->notifiable_type::find($notification->notifiable_id);
        }

        return view('notifications.show', compact('notification', 'relatedContent'));
    }
}
