<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
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
            ->where('status', 'published')
            ->firstOrFail();

        $registrasi = Registration::where('event_id', $event->id)
            ->where('user_id', session('user_id'))
            ->first(); 

        $isSaved = \App\Models\SavedEvent::where('user_id', session('user_id'))->where('event_id', $event->id)->exists();
        $isLiked = \App\Models\LikedEvent::where('user_id', session('user_id'))->where('event_id', $event->id)->exists();
        return view('volunteer.events.show', compact('event', 'registrasi', 'isSaved', 'isLiked'));
    }
}