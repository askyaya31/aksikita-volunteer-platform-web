<?php

namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\LikedEvent;
use Illuminate\Http\Request;

class LikedEventController extends Controller
{
    // GET /volunteer/liked-events
    public function index(Request $request)
    {
        $likedEvents = LikedEvent::with(['event.organization', 'event.categories'])
            ->where('user_id', session('user_id'))
            ->whereHas('event')
            ->latest('liked_at')
            ->paginate(9);

        return view('volunteer.liked-events', compact('likedEvents'));
    }

    // POST /volunteer/events/{id}/like → toggle
    public function toggle(Request $request, int $id)
    {
        $event  = Event::findOrFail($id);
        $userId = session('user_id');

        $existing = LikedEvent::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $event->decrement('likes_count');

            return back()->with('success', 'Suka pada kegiatan dibatalkan.');
        }

        LikedEvent::create([
            'user_id'  => $userId,
            'event_id' => $event->id,
        ]);
        $event->increment('likes_count');

        return back()->with('success', 'Kegiatan berhasil disukai!');
    }
}