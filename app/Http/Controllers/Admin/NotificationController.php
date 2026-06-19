<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function list(Request $request)
    {
        $query = auth()->user()->notifications()->latest();

        // Status filter: all | unread | read
        $status = $request->get('status', 'all');
        if ($status === 'unread') {
            $query->whereNull('read_at');
        } elseif ($status === 'read') {
            $query->whereNotNull('read_at');
        }

        // Date filter
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }

        $notifications = $query->paginate(15)->appends($request->query());

        return view('admin.notifications.index', compact('notifications', 'status'));
    }

    public function index()
    {
        $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();
        $count = auth()->user()->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'count' => $count
        ]);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
