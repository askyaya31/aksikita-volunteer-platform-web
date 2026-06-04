<?php
namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\StoreEventRequest;
use App\Http\Requests\Organization\UpdateEventRequest;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    private function getOrgProfile(Request $request)
    {
        return $request->user()->organizationProfile;
    }

    public function index(Request $request)
    {
        $events = Event::with('categories')
            ->where('organization_profile_id', $this->getOrgProfile($request)->id)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return EventResource::collection($events);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $org        = $this->getOrgProfile($request);
        $posterPath = null;

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }
        $event = Event::create([
            ...$request->validatedEventData(),
            'organization_profile_id' => $org->id,
            'slug'                    => Str::slug($request->title) . '-' . Str::random(6),
            'poster'                  => $posterPath,
            'status'                  => 'draft',
        ]);

        if ($request->has('category_ids')) {
            $event->categories()->attach($request->category_ids);
        }

        return response()->json([
            'message' => 'Event berhasil dibuat sebagai draft. Gunakan endpoint submit untuk mengajukan ke review.',
            'event'   => new EventResource($event->load('categories')),
        ], 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $event = Event::with(['categories', 'registrations.user'])
            ->where('organization_profile_id', $this->getOrgProfile($request)->id)
            ->findOrFail($id);

        return response()->json([
            'event' => new EventResource($event),
        ]);
    }

    public function update(UpdateEventRequest $request, int $id): JsonResponse
    {
        $event = Event::where('organization_profile_id', $this->getOrgProfile($request)->id)
            ->findOrFail($id);

        // hanya event berstatus draft atau rejected yang boleh diedit
        if (!in_array($event->status, ['draft', 'rejected'])) {
            return response()->json([
                'message' => 'Event yang sudah diajukan atau disetujui tidak bisa diedit.',
            ], 422);
        }

        $data = $request->validatedEventData();

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);
        if ($request->has('category_ids')) {
            $event->categories()->sync($request->category_ids);
        }

        return response()->json([
            'message' => 'Event berhasil diupdate.',
            'event'   => new EventResource($event->load('categories')),
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $event = Event::where('organization_profile_id', $this->getOrgProfile($request)->id)
            ->findOrFail($id);

        if (!in_array($event->status, ['draft', 'rejected'])) {
            return response()->json([
                'message' => 'Hanya event berstatus draft atau rejected yang bisa dihapus.',
            ], 422);
        }
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return response()->json(['message' => 'Event berhasil dihapus.']);
    }

    public function submit(Request $request, int $id): JsonResponse
    {
        $org   = $this->getOrgProfile($request);
        $event = Event::where('organization_profile_id', $org->id)
            ->where('status', 'draft')
            ->findOrFail($id);

        $event->update(['status' => 'pending_review']);

        // kirim notifikasi ke semua admin bahwa ada event baru yang perlu direview
        User::where('role', 'admin')->each(function ($admin) use ($event, $org) {
            Notification::create([
                'user_id'          => $admin->id,
                'title'            => 'Event Baru Menunggu Review',
                'message'          => "Event '{$event->title}' oleh {$org->organization_name} memerlukan review.",
                'type'             => 'event_pending_review',
                'related_event_id' => $event->id,
            ]);
        });

        return response()->json([
            'message' => 'Event berhasil diajukan untuk review admin.',
            'event'   => new EventResource($event->load('categories')),
        ]);
    }

    public function complete(Request $request, int $id): JsonResponse
    {
        $org   = $this->getOrgProfile($request);
        $event = Event::where('organization_profile_id', $org->id)
            ->where('status', 'published')
            ->findOrFail($id);

        $event->update(['status' => 'completed']);

        // kirim notifikasi ke semua volunteer yang terdaftar
        Registration::where('event_id', $event->id)
            ->where('status', 'confirmed')
            ->with('user')
            ->get()
            ->each(function ($reg) use ($event) {
                Notification::create([
                    'user_id'          => $reg->user_id,
                    'title'            => 'Kegiatan Selesai',
                    'message'          => "Kegiatan '{$event->title}' telah selesai. Terima kasih sudah berpartisipasi!",
                    'type'             => 'event_completed',
                    'related_event_id' => $event->id,
                ]);
            });

        return response()->json([
            'message' => 'Event berhasil ditandai selesai.',
            'event'   => new EventResource($event->load('categories')),
        ]);
    }

    public function cancel(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $org   = $this->getOrgProfile($request);
        $event = Event::where('organization_profile_id', $org->id)
            ->whereIn('status', ['published', 'pending_review', 'draft'])
            ->findOrFail($id);

        $event->update([
            'status'           => 'cancelled',
            'rejection_reason' => $request->reason,
        ]);

        // kirim notifikasi ke semua volunteer yang sudah terdaftar
        Registration::where('event_id', $event->id)
            ->where('status', 'confirmed')
            ->get()
            ->each(function ($reg) use ($event, $request) {
                Notification::create([
                    'user_id'          => $reg->user_id,
                    'title'            => 'Event Dibatalkan',
                    'message'          => "Mohon maaf, event '{$event->title}' telah dibatalkan oleh penyelenggara." .
                        ($request->reason ? " Alasan: {$request->reason}" : ''),
                    'type'             => 'event_cancelled',
                    'related_event_id' => $event->id,
                ]);
            });

        return response()->json([
            'message' => 'Event berhasil dibatalkan.',
            'event'   => new EventResource($event->load('categories')),
        ]);
    }
}
