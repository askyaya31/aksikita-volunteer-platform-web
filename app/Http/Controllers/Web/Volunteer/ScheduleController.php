<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year',  now()->year);
        $month = max(1, min(12, $month));

        $registrations = Registration::with(['event.organization', 'event.categories'])
            ->where('user_id', session('user_id'))
            ->whereIn('status', ['confirmed', 'attended'])
            ->whereHas('event', fn($q) => $q->whereNotNull('start_date'))
            ->get()
            ->filter(fn($r) => $r->event !== null);

        $schedule = $registrations
            ->sortBy(fn($r) => $r->event->start_date->format('Y-m-d') . $r->event->start_time)
            ->groupBy(fn($r) => $r->event->start_date->format('Y-m-d'));

        $today    = Carbon::today()->toDateString();
        $upcoming = $schedule->filter(fn($g, $date) => $date >= $today);
        $past     = $schedule->filter(fn($g, $date) => $date <  $today)->reverse();

        $eventsByDate = $registrations
            ->groupBy(fn($r) => $r->event->start_date->format('Y-m-d'))
            ->map(fn($regs) => $regs->map(fn($r) => [
                'title'      => $r->event->title,
                'start_time' => $r->event->start_time
                    ? Carbon::parse($r->event->start_time)->format('H:i')
                     : null,
                'end_time'   => $r->event->end_time
                    ? Carbon::parse($r->event->end_time)->format('H:i')
                    : null,
                'slug'       => $r->event->slug,
                'status'     => $r->status,
            ])->values()->toArray())
            ->toArray();

        $calendarMonth = Carbon::createFromDate($year, $month, 1);
        $prevMonth     = $calendarMonth->copy()->subMonth();
        $nextMonth     = $calendarMonth->copy()->addMonth();

        return view('volunteer.schedule', compact(
            'upcoming', 'past',
            'eventsByDate', 'calendarMonth', 'prevMonth', 'nextMonth'
        ));
    }
}