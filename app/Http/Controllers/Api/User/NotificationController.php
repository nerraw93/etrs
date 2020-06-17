<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display list of unread announcements
     *
     * @return response
     */
    public function announcementUnread()
    {
        $notifications = get_current_notifications(auth()->user()->notifications()->get());
        return success_data(compact('notifications'));
    }

    /**
     * Get all notifications
     *
     * @return response
     */
    public function getAllNotifications(Request $request)
    {
        if ($request->has('page') && $request->page == 'all') {
            $notifications = get_current_notifications(auth()->user()->notifications()->get());
            return success_data(compact('notifications'));
        }

        $count = $request->input('count') ? $request->input('count') : 10;
        $notifications = auth()->user()->notifications()->paginate($count);
        return success_data(compact('notifications'));
    }

    /**
     * Update notifications read status
     * @param  Request $request
     * @return response
     */
    public function updateRead(Request $request)
    {
        if ($request->has('id')) {
            if ($request->id == 'all') {
                // Mark all notifications as read!
                $notification = auth()->user()->unreadNotifications;
                foreach ($notification as $unread) {
                    $unread->markAsRead();
                }
            } else {
                // Update notification individually
                $notification = auth()->user()->notifications()->find($request->id);
                if($notification) {
                    $notification->markAsRead();
                }
            }

            return success_data(compact('notification'));
        }
    }
}
