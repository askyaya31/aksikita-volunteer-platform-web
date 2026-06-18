<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request, int $id)
    {
        $event = Event::findOrFail($id);

        if ($event->status !== 'published') {
            return back()->with('error', 'Event ini tidak menerima pendaftaran.');
        }
        if ($event->isFull()) {
            return back()->with('error', 'Kuota pendaftaran sudah penuh.');
        }
        if (Registration::where('event_id', $id)->where('user_id', session('user_id'))->exists()) {
            return back()->with('error', 'Kamu sudah terdaftar di event ini.');
        }
        $conflict = $this->checkScheduleConflict(session('user_id'), $event);
        if ($conflict) {
            return back()->with('warning',
                "⚠ Jadwal bertabrakan dengan kegiatan \"{$conflict->event->title}\" " .
                "pada {$conflict->event->start_date->translatedFormat('d F Y')}."
            )->with('conflict_event_id', $conflict->event->id);
        }


        Registration::create([
            'event_id'      => $event->id,
            'user_id'       => session('user_id'),
            'status'        => 'pending',
            'registered_at' => now(),
            'notes'         => $request->notes,
        ]);
        return back()->with('success', 'Pendaftaran berhasil!');
    }

    public function cancel(Request $request, int $id)
    {
        $registration = Registration::with('event')
            ->where('event_id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        if ($registration->event->status === 'completed') {
            return back()->with('error', 'Tidak bisa membatalkan event yang sudah selesai.');
        }

        $registration->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        if ($registration->status === 'confirmed') {
            $registration->event->decrement('registered_count');
        }

        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }

    private function checkScheduleConflict(int $userId, Event $newEvent): ?Registration
    {
        if (!$newEvent->start_time || !$newEvent->end_time) {
            return null;
        }

        $newStart = \Carbon\Carbon::parse($newEvent->start_date->toDateString() . ' ' . $newEvent->start_time);
        $newEnd   = \Carbon\Carbon::parse($newEvent->end_date->toDateString()   . ' ' . $newEvent->end_time);

        return Registration::with('event')
            ->where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'pending'])
            ->whereHas('event', function ($q) use ($newEvent) {
                $q->where('id', '!=', $newEvent->id)
                ->whereNotNull('start_time')
                ->whereNotNull('end_time');
            })
            ->get()
            ->first(function ($reg) use ($newStart, $newEnd) {
                $e = $reg->event;
                $existStart = \Carbon\Carbon::parse($e->start_date->toDateString() . ' ' . $e->start_time);
                $existEnd   = \Carbon\Carbon::parse($e->end_date->toDateString()   . ' ' . $e->end_time);
                return $newStart->lt($existEnd) && $newEnd->gt($existStart);
            });
    }

    public function history(Request $request)
    {
        $tab = $request->get('tab', 'aktif');

        if ($tab === 'aktif') {
    $registrations = Registration::with(['event.organization', 'event.categories'])
        ->where('user_id', session('user_id'))
        ->whereIn('status', ['pending', 'confirmed', 'attended'])   
        ->latest()
        ->paginate(10);
} else {
    $registrations = Registration::with(['event.organization', 'event.categories'])
        ->where('user_id', session('user_id'))
        ->where('status', 'cancelled')
        ->latest()
        ->paginate(10);
}

        return view('volunteer.history', compact('registrations', 'tab'));
    }
}
