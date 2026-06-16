<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizationProfile;
use App\Models\Registration;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
       
        $users = [
            'total'         => User::count(),
            'volunteers'    => User::where('role', 'volunteer')->count(),
            'organizations' => User::where('role', 'organization')->count(),
            'admins'        => User::where('role', 'admin')->count(),
            'inactive'      => User::where('is_active', false)->count(),
        ];

        $organizations = [
            'total'    => OrganizationProfile::count(),
            'pending'  => OrganizationProfile::where('verification_status', 'pending')->count(),
            'verified' => OrganizationProfile::where('verification_status', 'verified')->count(),
            'rejected' => OrganizationProfile::where('verification_status', 'rejected')->count(),
        ];

        $events = [
            'total'          => Event::count(),
            'draft'          => Event::where('status', 'draft')->count(),
            'pending_review' => Event::where('status', 'pending_review')->count(),
            'published'      => Event::where('status', 'published')->count(),
            'rejected'       => Event::where('status', 'rejected')->count(),
            'completed'      => Event::where('status', 'completed')->count(),
            'cancelled'      => Event::where('status', 'cancelled')->count(),
        ];

        $registrations = [
            'total'     => Registration::count(),
            'confirmed' => Registration::where('status', 'confirmed')->count(),
            'pending'   => Registration::where('status', 'pending')->count(),
            'cancelled' => Registration::where('status', 'cancelled')->count(),
            'attended'  => Registration::where('status', 'attended')->count(),
        ];

        $reports = [
            'total'        => Report::count(),
            'open'         => Report::where('status', 'open')->count(),
            'under_review' => Report::where('status', 'under_review')->count(),
            'resolved'     => Report::where('status', 'resolved')->count(),
            'dismissed'    => Report::where('status', 'dismissed')->count(),
        ];

        $registrationTrend = Registration::select(
                DB::raw("DATE_FORMAT(registered_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('registered_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $eventTrend = Event::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $userTrend = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthNames = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar',
            '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Agt', '09' => 'Sep',
            '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
        ];

        $trendLabels    = [];
        $trendData      = [];
        $eventTrendData = [];
        $userTrendData  = [];

        for ($i = 5; $i >= 0; $i--) {
            $date           = now()->subMonths($i);
            $key            = $date->format('Y-m');
            $monthNum       = $date->format('m');
            $year           = $date->format('Y');
            $trendLabels[]  = ($monthNames[$monthNum] ?? $monthNum) . ' ' . $year;
            $trendData[]    = $registrationTrend[$key] ?? 0;
            $eventTrendData[] = $eventTrend[$key] ?? 0;
            $userTrendData[]  = $userTrend[$key] ?? 0;
        }

        return view('admin.statistics', compact(
            'users', 'organizations', 'events', 'registrations', 'reports',
            'trendLabels', 'trendData', 'eventTrendData', 'userTrendData'
        ));
    }
}