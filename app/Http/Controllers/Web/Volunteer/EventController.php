<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\LikedEvent;
use App\Models\Registration;
use App\Models\SavedEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with(['organization', 'categories'])
            ->where('status', 'published')
            ->where('start_date', '>=', now()->toDateString())
            ->when($request->search,   fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->city,     fn($q) => $q->where('city', $request->city))
            ->when($request->category, fn($q) => $q->whereHas('categories', fn($c) => $c->where('slug', $request->category)))
            ->orderBy('start_date')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();

        return view('volunteer.events.index', compact('events', 'categories'));
    }

    public function show(string $slug)
    {
        $event = Event::with(['organization', 'categories'])
            ->where('slug', $slug)
            ->whereIn('status', ['published', 'completed'])
            ->firstOrFail();

        $userId = session('user_id');

        $registrasi = Registration::where('event_id', $event->id)
            ->where('user_id', $userId)
            ->first();
        $registrasi = Registration::with('chatRoom')
            ->where('user_id', session('user_id'))
            ->where('event_id', $event->id)
            ->first();

        $isSaved = SavedEvent::where('user_id', $userId)->where('event_id', $event->id)->exists();
        $isLiked = LikedEvent::where('user_id', $userId)->where('event_id', $event->id)->exists();

        $filled = $event->quota > 0
            ? round((($event->quota - $event->remainingQuota()) / $event->quota) * 100)
            : 0;

        return view('volunteer.events.show', compact('event', 'registrasi', 'isSaved', 'isLiked', 'filled'));
    }

    public function showPublic(string $slug)
    {
        $event = Event::with(['organization', 'categories'])
            ->where('slug', $slug)
            ->whereIn('status', ['published', 'completed'])
            ->firstOrFail();

        return view('events.show', compact('event'));
    }
}