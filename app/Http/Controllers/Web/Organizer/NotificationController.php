<?php
namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', session('user_id'))
            ->latest()
            ->paginate(15);
            
        Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('organizer.notifications', compact('notifications'));
    }

    public function markRead(int $id)
    {
        Notification::where('user_id', session('user_id'))
            ->findOrFail($id)
            ->update(['is_read' => true]);

        return back();
    }
}