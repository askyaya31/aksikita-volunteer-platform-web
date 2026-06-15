<?php

namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegistrationResource;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $user  = $request->user();
        $event = Event::with('organization.user')->findOrFail($id);

        if ($event->status !== 'published') {
            return response()->json([
                'message' => 'Event ini tidak sedang membuka pendaftaran.',
            ], 422);
        }

        if ($event->isFull()) {
            return response()->json([
                'message' => 'Kuota event ini sudah penuh.',
            ], 422);
        }

        $alreadyRegistered = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($alreadyRegistered) {
            return response()->json([
                'message' => 'Kamu sudah mendaftar ke event ini.',
            ], 422);
        }

        $registration = Registration::create([
            'user_id'       => $user->id,
            'event_id'      => $event->id,
            'notes'         => $request->notes,
            'status'        => 'pending',
            'registered_at' => now(),
        ]);

        $event->increment('registered_count');

        Notification::create([
            'user_id'          => $user->id,
            'title'            => 'Pendaftaran Berhasil Dikirim',
            'message'          => "Pendaftaran kamu untuk event \"{$event->title}\" berhasil dikirim. Tunggu konfirmasi dari organisasi!",
            'type'             => 'registration_pending',
            'related_event_id' => $event->id,
        ]);

        $orgUserId = $event->organization?->user_id;
        if ($orgUserId) {
            Notification::create([
                'user_id'          => $orgUserId,
                'title'            => 'Pendaftar Baru!',
                'message'          => "{$user->name} mendaftar ke event \"{$event->title}\". Segera tinjau pendaftarannya.",
                'type'             => 'new_registration',
                'related_event_id' => $event->id,
            ]);
        }

        return response()->json([
            'message'      => 'Pendaftaran berhasil dikirim! Menunggu konfirmasi dari organisasi.',
            'registration' => new RegistrationResource($registration->load('event')),
        ], 201);
    }

    public function cancel(Request $request, int $id): JsonResponse
    {
        $request->validate(['reason' => 'nullable|string|max:500']);

        $registration = Registration::where('user_id', $request->user()->id)
        ->where('event_id', $id)          
        ->whereNotIn('status', ['cancelled'])
        ->firstOrFail();

        if ($registration->status === 'cancelled') {
            return response()->json(['message' => 'Pendaftaran sudah dibatalkan.'], 422);
        }

        if ($registration->event?->status === 'completed') {
            return response()->json(['message' => 'Event sudah selesai.'], 422);
        }

        $registration->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $request->reason,
        ]);

        $registration->event?->decrement('registered_count');

        return response()->json(['message' => 'Pendaftaran berhasil dibatalkan.']);
    }

    public function index(Request $request)
    {
        $registrations = Registration::with(['event.organization', 'event.categories'])
            ->where('user_id', $request->user()->id)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest('registered_at')
            ->paginate(15);

        return RegistrationResource::collection($registrations);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $registration = Registration::with(['event.organization', 'event.categories'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json(['registration' => new RegistrationResource($registration)]);
    }
}