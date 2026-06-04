<?php
namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\RegistrationResource;

class RegistrationController extends Controller
{
    public function store(Request $request, int $id): JsonResponse
    {
        $user  = $request->user();
        $event = Event::findOrFail($id);

        // cek 1: event harus berstatus published
        if ($event->status !== 'published') {
            return response()->json([
                'message' => 'Event ini tidak menerima pendaftaran saat ini.',
            ], 422);
        }

        // cek 2: event tidak boleh sudah lewat tanggalnya
        if ($event->end_date < now()->toDateString()) {
            return response()->json([
                'message' => 'Event ini sudah selesai.',
            ], 422);
        }

        // cek 3: kuota tidak boleh penuh
        if ($event->isFull()) {
            return response()->json([
                'message' => 'Kuota pendaftaran sudah penuh.',
            ], 422);
        }

        // cek 4: volunteer tidak boleh daftar dua kali ke event yang sama
        $sudahDaftar = Registration::where('event_id', $id)
            ->where('user_id', $user->id)
            ->exists();

        if ($sudahDaftar) {
            return response()->json([
                'message' => 'Anda sudah terdaftar di event ini.',
            ], 422);
        }

        try {
            $registration = Registration::create([
                'event_id'      => $event->id,
                'user_id'       => $user->id,
                'status'        => 'confirmed',
                'registered_at' => now(),
                'notes'         => $request->notes,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'Anda sudah terdaftar di event ini.',
                ], 422);
            }
            throw $e;
        }

        $event->increment('registered_count');
        $user->volunteerProfile->increment('total_events_joined');

        return response()->json([
            'message'      => 'Pendaftaran berhasil!',
            'registration' => new RegistrationResource($registration->load('event')),
        ], 201);
    }

    public function cancel(Request $request, int $id): JsonResponse
    {
        $registration = Registration::with('event')
            ->where('event_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($registration->status === 'cancelled') {
            return response()->json([
                'message' => 'Pendaftaran ini sudah dibatalkan sebelumnya.',
            ], 422);
        }

        if ($registration->event->status === 'completed') {
            return response()->json([
                'message' => 'Tidak dapat membatalkan pendaftaran untuk event yang sudah selesai.',
            ], 422);
        }

        $registration->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $request->reason,
        ]);

        $registration->event->decrement('registered_count');
$registration->user->volunteerProfile->decrement('total_events_joined');
        return response()->json(['message' => 'Pendaftaran berhasil dibatalkan.']);
    }

    public function index(Request $request)
    {
        $registrations = Registration::with(['event.categories', 'event.organization'])
            ->where('user_id', $request->user()->id)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return RegistrationResource::collection($registrations);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $registration = Registration::with(['event.categories', 'event.organization'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'registration' => new RegistrationResource($registration),
        ]);
    }
}