<?php
namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with(['organization', 'categories'])
            ->where('status', 'published')
            ->when($request->search,     fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->city,       fn($q) => $q->where('city', $request->city))
            ->when($request->province,   fn($q) => $q->where('province', $request->province))
            ->when($request->category,   fn($q) => $q->whereHas('categories', fn($c) => $c->where('slug', $request->category)))
            ->when($request->start_date, fn($q) => $q->where('start_date', '>=', $request->start_date))
            ->latest('start_date')
            ->paginate(12);

        return EventResource::collection($events);
    }

    public function show(string $slug): JsonResponse
    {
        $event = Event::with(['organization', 'categories'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json([
            'event' => new EventResource($event),
        ]);
    }
}