<?php
namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'review');

        $statusMap = [
            'review'   => 'pending_review',
            'aktif'    => 'published',
            'selesai'  => 'completed',
            'ditolak'  => 'rejected',
        ];

        $events = Event::with('organization')
            ->where('status', $statusMap[$tab] ?? 'pending_review')
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        return view('admin.events', compact('events', 'tab'));
    }

    public function show(int $id)
    {
        $event = Event::with([
            'organization.user',
            'categories',
            'reviewer',
            'registrations',
        ])->findOrFail($id);

        return view('admin.events.show', compact('event'));
    }

    public function review(Request $request, int $id)
    {
        $request->validate([
            'action'           => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string',
        ]);

        $event = Event::with('organization.user')->findOrFail($id);

        if ($request->action === 'approve') {
            $event->update([
                'status'           => 'published',
                'rejection_reason' => null,
                'reviewed_by'      => session('user_id'),
                'reviewed_at'      => now(),
            ]);
            $title   = 'Event Disetujui!';
            $message = "Event '{$event->title}' Anda telah disetujui dan sekarang tampil di platform.";
        } else {
            $event->update([
                'status'           => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'reviewed_by'      => session('user_id'),
                'reviewed_at'      => now(),
            ]);
            $title   = 'Event Ditolak';
            $message = "Event '{$event->title}' Anda ditolak. Alasan: {$request->rejection_reason}";
        }

        if ($event->organization?->user_id) {
            Notification::create([
                'user_id'          => $event->organization->user_id,
                'title'            => $title,
                'message'          => $message,
                'type'             => 'event_reviewed',
                'related_event_id' => $event->id,
            ]);
        }

        return redirect()
            ->route('admin.events.show', $event->id)
            ->with('success', 'Event berhasil di-review.');
    }
}