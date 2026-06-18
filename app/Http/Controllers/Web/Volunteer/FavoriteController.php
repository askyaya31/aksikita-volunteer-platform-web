<?php

namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\LikedEvent;
use App\Models\SavedEvent;

class FavoriteController extends Controller
{
    public function saved()
    {
        $events = SavedEvent::with([
                'event.organization',
                'event.categories'
            ])
            ->where('user_id', session('user_id'))
            ->latest('saved_at')
            ->paginate(12);

        return view('volunteer.saved-events', compact('events'));
    }

    public function liked()
    {
        $events = LikedEvent::with([
                'event.organization',
                'event.categories'
            ])
            ->where('user_id', session('user_id'))
            ->latest('liked_at')
            ->paginate(12);

        return view('volunteer.liked-events', compact('events'));
    }
}