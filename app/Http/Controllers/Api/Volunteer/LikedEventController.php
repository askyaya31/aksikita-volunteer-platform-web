<?php
namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\LikedEvent;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikedEventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $liked = LikedEvent::with(['event.organization', 'event.categories'])
            ->where('user_id', $request->user()->id)
            ->latest('liked_at')
            ->get();

        $data = $liked->map(fn($l) => [
            'id'       => $l->id,
            'event_id' => $l->event_id,
            'liked_at' => $l->liked_at,
            'event'    => $l->event ? new EventResource($l->event) : null,
        ]);

        return response()->json(['data' => $data]);
    }

    public function toggle(Request $request, int $id): JsonResponse
    {
        $user  = $request->user();
        $liked = LikedEvent::where('user_id', $user->id)
            ->where('event_id', $id)
            ->first();

        $event = Event::findOrFail($id);

        if ($liked) {
            $liked->delete();
            $event->decrement('likes_count');
            return response()->json([
                'liked'       => false,
                'likes_count' => max(0, $event->fresh()->likes_count),
                'message'     => 'Suka dibatalkan.',
            ]);
        }

        LikedEvent::create(['user_id' => $user->id, 'event_id' => $id]);
        $event->increment('likes_count');

        return response()->json([
            'liked'       => true,
            'likes_count' => $event->fresh()->likes_count,
            'message'     => 'Kegiatan disukai!',
        ]);
    }
}