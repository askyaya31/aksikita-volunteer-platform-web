<?php

namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\OrganizationProfile;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $org = OrganizationProfile::where('user_id', $userId)->first();

        if (!$org) {
            return redirect()->route('login')->with('error', 'Profil organisasi tidak ditemukan.');
        }

        $orgId = $org->id;

        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);
        if ($month < 1 || $month > 12) $month = now()->month;

        $calendarMonth = Carbon::create($year, $month, 1);

        $events = Event::where('organization_profile_id', $orgId)
            ->whereIn('status', ['published', 'completed'])
            ->where(function ($q) use ($year, $month) {
                $q->whereYear('start_date', $year)
                  ->whereMonth('start_date', $month)
                  ->orWhereRaw('YEAR(end_date) = ? AND MONTH(end_date) = ?', [$year, $month]);
            })
            ->withCount('registrations')
            ->orderBy('start_date')
            ->get();

        $today = Carbon::today();
        $eventsByDate = $events->groupBy(fn($e) => $e->start_date->format('Y-m-d'));

        $upcoming = $eventsByDate->filter(fn($d, $date) => Carbon::parse($date)->gte($today));
        $past     = $eventsByDate->filter(fn($d, $date) => Carbon::parse($date)->lt($today));

        $prevMonth = $calendarMonth->copy()->subMonth();
        $nextMonth = $calendarMonth->copy()->addMonth();

        return view('organizer.schedule', compact(
            'org',
            'upcoming', 'past', 'eventsByDate', 'calendarMonth',
            'prevMonth', 'nextMonth', 'month', 'year'
        ));
    }
}