<?php

namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $month  = (int) $request->get('month', now()->month);
        $year   = (int) $request->get('year',  now()->year);
        $month  = max(1, min(12, $month));

        $registrations = Registration::with(['event.organization'])
            ->where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'attended'])
            ->whereHas('event', fn($q) => $q->whereNotNull('start_date'))
            ->get()
            ->filter(fn($r) => $r->event !== null);

        $today = Carbon::today()->toDateString();

        $format = function ($r) {
            $event = $r->event;
            return [
                'registrationId' => $r->id,
                'eventTitle'     => $event->title,
                'eventSlug'      => $event->slug ?? '',
                'organizerName'  => $event->organization?->organization_name ?? '',
                'startDate'      => $event->start_date?->format('Y-m-d') ?? '',
                'startTime'      => $event->start_time
                                        ? Carbon::parse($event->start_time)->format('H:i')
                                        : null,
                'endTime'        => $event->end_time
                                        ? Carbon::parse($event->end_time)->format('H:i')
                                        : null,
                'location'       => trim(
                                        ($event->location_name ?? '') . ' ' . ($event->city ?? '')
                                    ),
                'status'         => $r->status,
                'posterUrl'      => $event->poster
                                        ? \Illuminate\Support\Facades\Storage::url($event->poster)
                                        : null,
            ];
        };

        $sorted   = $registrations->sortBy(fn($r) => $r->event->start_date->format('Y-m-d'));
        $upcoming = $sorted->filter(fn($r) => $r->event->start_date->format('Y-m-d') >= $today)
                           ->values()
                           ->map($format);
        $past     = $sorted->filter(fn($r) => $r->event->start_date->format('Y-m-d') < $today)
                           ->sortByDesc(fn($r) => $r->event->start_date->format('Y-m-d'))
                           ->values()
                           ->map($format);

        $eventsByDate = $registrations
            ->groupBy(fn($r) => $r->event->start_date->format('Y-m-d'))
            ->map(fn($regs) => $regs->map(fn($r) => [
                'title'     => $r->event->title,
                'startTime' => $r->event->start_time
                                    ? Carbon::parse($r->event->start_time)->format('H:i')
                                    : null,
                'slug'      => $r->event->slug ?? '',
                'status'    => $r->status,
            ])->values())
            ->toArray();

        return response()->json([
            'upcoming'     => $upcoming,
            'past'         => $past,
            'eventsByDate' => $eventsByDate,
        ]);
    }
}