<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::with('volunteerProfile')->find(session('user_id'));
        $city = $user->volunteerProfile?->city;

        $nearbyEvents = Event::with(['organization', 'categories'])
            ->where('status', 'published')
            ->when($city, fn($q) => $q->where('city', $city))
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        $latestEvents = Event::with(['organization', 'categories'])
            ->where('status', 'published')
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->limit(6)
            ->get();

        $unreadCount = Notification::where('user_id', session('user_id'))
            ->where('is_read', false)->count();
        session(['unread_count' => $unreadCount]);

        return view('volunteer.dashboard', compact('user', 'nearbyEvents', 'latestEvents', 'unreadCount'));
    }
}