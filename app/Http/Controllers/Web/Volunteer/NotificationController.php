<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', session('user_id'))
            ->latest()
            ->paginate(20);

        Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        session(['unread_count' => 0]);

        return view('volunteer.notifications', compact('notifications'));
    }

    public function markRead(int $id)
    {
        Notification::where('id', $id)
            ->where('user_id', session('user_id'))
            ->update(['is_read' => true]);

        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        session(['unread_count' => 0]);

        return back()->with('success', 'Semua notifikasi sudah ditandai dibaca.');
    }
}
