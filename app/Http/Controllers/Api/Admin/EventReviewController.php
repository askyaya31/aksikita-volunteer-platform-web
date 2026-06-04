<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;

class EventReviewController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with(['organization', 'categories'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return EventResource::collection($events);
    }

    public function show(int $id): JsonResponse
    {
        $event = Event::with(['organization.user', 'categories', 'registrations'])->findOrFail($id);

        return response()->json([
            'event' => new EventResource($event),
        ]);
    }

    public function review(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'action'           => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|string|max:500',
        ]);

        $event = Event::findOrFail($id);
        $admin = $request->user();

        if ($request->action === 'approve') {
            $event->update([
                'status'      => 'published',
                'reviewed_by' => $admin->id,
                'reviewed_at' => now(),
            ]);

            // kirim notifikasi ke organisasi bahwa event disetujui
            Notification::create([
                'user_id'          => $event->organization->user_id,
                'title'            => 'Event Anda Disetujui!',
                'message'          => "Event '{$event->title}' telah disetujui dan sekarang tampil ke publik.",
                'type'             => 'event_approved',
                'related_event_id' => $event->id,
            ]);

            return response()->json(['message' => 'Event berhasil disetujui dan dipublikasikan.']);
        }

        $event->update([
            'status'           => 'rejected',
            'reviewed_by'      => $admin->id,
            'reviewed_at'      => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // kirim notifikasi ke organisasi bahwa event ditolak beserta alasannya
        Notification::create([
            'user_id'          => $event->organization->user_id,
            'title'            => 'Event Ditolak',
            'message'          => "Event '{$event->title}' ditolak. Alasan: {$request->rejection_reason}",
            'type'             => 'event_rejected',
            'related_event_id' => $event->id,
        ]);

        return response()->json(['message' => 'Event ditolak.']);
    }
}