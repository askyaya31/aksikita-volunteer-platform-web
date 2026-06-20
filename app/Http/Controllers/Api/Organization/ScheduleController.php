<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $org = $request->user()->organizationProfile;

        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);
        $month = max(1, min(12, $month));

        $events = Event::where('organization_profile_id', $org->id)
            ->where(function ($q) use ($year, $month) {
                $q->whereYear('start_date', $year)
                  ->whereMonth('start_date', $month)
                  ->orWhereRaw('YEAR(end_date) = ? AND MONTH(end_date) = ?', [$year, $month]);
            })
            ->withCount('registrations')
            ->orderBy('start_date')
            ->get();

        $today = Carbon::today()->toDateString();

        $sorted   = $events->sortBy(fn($e) => $e->start_date->format('Y-m-d'));
        $upcoming = $sorted->filter(fn($e) => $e->start_date->format('Y-m-d') >= $today)
                            ->values();
        $past     = $sorted->filter(fn($e) => $e->start_date->format('Y-m-d') < $today)
                            ->sortByDesc(fn($e) => $e->start_date->format('Y-m-d'))
                            ->values();

        $eventsByDate = $events
            ->groupBy(fn($e) => $e->start_date->format('Y-m-d'))
            ->map(fn($evts) => $evts->map(fn($e) => [
                'id'                 => $e->id,
                'title'              => $e->title,
                'slug'               => $e->slug,
                'startTime'          => $e->start_time
                                            ? Carbon::parse($e->start_time)->format('H:i')
                                            : null,
                'status'             => $e->status,
                'registrationsCount' => $e->registrations_count,
            ])->values())
            ->toArray();

        return response()->json([
            'upcoming'     => EventResource::collection($upcoming),
            'past'         => EventResource::collection($past),
            'eventsByDate' => $eventsByDate,
            'month'        => $month,
            'year'         => $year,
        ]);
    }
}