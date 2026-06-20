<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Services\EventRecommendationService;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $user   = User::with('volunteerProfile')->find($userId);
        $city   = $user?->volunteerProfile?->city;

        if ($user?->volunteerProfile?->avatar) {
            session(['user_avatar' => $user->volunteerProfile->avatar]);
        }

        $nearbyEvents = Event::with(['organization', 'categories'])
            ->where('status', 'published')
            ->when($city, fn($q) => $q->where('city', $city))
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        $latestEvents = Event::with(['organization', 'categories'])
            ->where('status', 'published')
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->limit(6)
            ->get();

        $unreadCount = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
        session(['unread_count' => $unreadCount]);

        $upcomingSchedule = Registration::with(['event.organization'])
            ->where('registrations.user_id', $userId)
            ->whereIn('registrations.status', ['confirmed', 'attended'])
            ->whereHas('event', fn($q) => $q->where('start_date', '>=', now()->toDateString()))
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->orderBy('events.start_date')
            ->orderBy('events.start_time')
            ->select('registrations.*')
            ->limit(3)
            ->get();

        $recommendations = collect();
        try {
            $recommendations = (new EventRecommendationService())->recommend($userId, 6);
        } catch (\Throwable $e) {
           
        }

        $fallbackEvents = collect();
        if ($recommendations->isEmpty()) {
            $fallbackEvents = Event::with(['organization', 'categories'])
                ->where('status', 'published')
                ->where('end_date', '>=', now()->toDateString())
                ->latest()
                ->limit(6)
                ->get();
        }

        return view('volunteer.dashboard', compact(
            'user', 'nearbyEvents', 'latestEvents',
            'unreadCount', 'upcomingSchedule',
            'recommendations', 'fallbackEvents'
        ));
    }
}