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
        $user = User::with('volunteerProfile')->find(session('user_id'));
        $city = $user->volunteerProfile?->city;
        $userId = session('user_id');

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

        $upcomingSchedule = \App\Models\Registration::with(['event.organization'])
            ->where('user_id', session('user_id'))
            ->whereIn('registrations.status', ['confirmed', 'attended'])
            ->whereHas('event', fn($q) => $q->where('start_date', '>=', now()->toDateString()))
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->orderBy('events.start_date')
            ->orderBy('events.start_time')
            ->select('registrations.*')
            ->limit(3)
            ->get();

         $recommendations = (new EventRecommendationService())->recommend($userId, 6);

        return view('volunteer.dashboard', compact(
            'user',
            'nearbyEvents',
            'latestEvents',
            'unreadCount',
            'upcomingSchedule',
            'recommendations'  
        ));
    }
}