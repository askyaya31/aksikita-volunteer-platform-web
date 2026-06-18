<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', session('user_id'))
            ->latest()
            ->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }

    public function markRead(int $id)
    {
        Notification::where('id', $id)
            ->where('user_id', session('user_id'))
            ->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead()
    {
        Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi sudah ditandai dibaca.');
    }
}