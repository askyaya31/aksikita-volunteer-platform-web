<?php
namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\RegistrationResource;

class RegistrationController extends Controller
{
    public function index(Request $request, int $id)
    {
        $org   = $request->user()->organizationProfile;
        $event = Event::where('organization_profile_id', $org->id)->findOrFail($id);

        $registrations = Registration::with('user.volunteerProfile')
            ->where('event_id', $event->id)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return RegistrationResource::collection($registrations);
    }

    public function confirm(Request $request, int $id): JsonResponse
    {
        $registration = $this->findOwnedRegistration($request, $id);

        if ($registration->status !== 'pending') {
            return response()->json(['message' => 'Hanya pendaftaran berstatus pending yang bisa dikonfirmasi.'], 422);
        }

        $registration->update(['status' => 'confirmed']);

        // kirim notifikasi ke volunteer bahwa pendaftarannya diterima
        Notification::create([
            'user_id'          => $registration->user_id,
            'title'            => 'Pendaftaran Diterima!',
            'message'          => "Selamat! Pendaftaran kamu untuk event '{$registration->event->title}' telah diterima.",
            'type'             => 'registration_confirmed',
            'related_event_id' => $registration->event_id,
        ]);

        return response()->json(['message' => 'Volunteer berhasil diterima.']);
    }

    // tolak volunteer
    public function reject(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $registration = $this->findOwnedRegistration($request, $id);

        if ($registration->status !== 'pending') {
            return response()->json(['message' => 'Hanya pendaftaran berstatus pending yang bisa ditolak.'], 422);
        }

        $registration->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $request->reason,
        ]);

        $registration->event->decrement('registered_count');

        // kirim notifikasi ke volunteer bahwa pendaftarannya ditolak
        Notification::create([
            'user_id'          => $registration->user_id,
            'title'            => 'Pendaftaran Tidak Diterima',
            'message'          => "Maaf, pendaftaran kamu untuk event '{$registration->event->title}' tidak dapat diterima." .
                ($request->reason ? " Alasan: {$request->reason}" : ''),
            'type'             => 'registration_rejected',
            'related_event_id' => $registration->event_id,
        ]);

        return response()->json(['message' => 'Volunteer berhasil ditolak.']);
    }

    public function attend(Request $request, int $id): JsonResponse
    {
        $registration = $this->findOwnedRegistration($request, $id);

        if ($registration->status !== 'confirmed') {
            return response()->json([
                'message' => 'Hanya pendaftaran berstatus confirmed yang bisa ditandai hadir.',
            ], 422);
        }

        if ($registration->event->start_date->isFuture()) {
            return response()->json([
                'message' => 'Tidak bisa menandai kehadiran sebelum event dimulai.',
            ], 422);
        }

        $registration->update(['status' => 'attended']);
        Notification::create([
            'user_id'          => $registration->user_id,
            'title'            => 'Kehadiran Tercatat',
            'message'          => "Kehadiran kamu di event '{$registration->event->title}' telah berhasil dicatat. Terima kasih!",
            'type'             => 'attendance_recorded',
            'related_event_id' => $registration->event_id,
        ]);

        return response()->json(['message' => 'Kehadiran volunteer berhasil dicatat.']);
    }
    private function findOwnedRegistration(Request $request, int $registrationId): Registration
    {
        $org = $request->user()->organizationProfile;

        return Registration::with('event')
            ->whereHas('event', fn($q) => $q->where('organization_profile_id', $org->id))
            ->findOrFail($registrationId);
    }
}
