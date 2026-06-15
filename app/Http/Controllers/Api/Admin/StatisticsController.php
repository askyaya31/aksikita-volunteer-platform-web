<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizationProfile;
use App\Models\Registration;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * GET /api/v1/admin/dashboard
     * Ringkasan singkat untuk dashboard card.
     */
    public function index()
    {
        return response()->json([
            'users'         => [
                'total'         => User::count(),
                'volunteers'    => User::where('role', 'volunteer')->count(),
                'organizations' => User::where('role', 'organization')->count(),
                'admins'        => User::where('role', 'admin')->count(),
                'inactive'      => User::where('is_active', false)->count(),
            ],
            'organizations' => [
                'total'    => OrganizationProfile::count(),
                'pending'  => OrganizationProfile::where('verification_status', 'pending')->count(),
                'verified' => OrganizationProfile::where('verification_status', 'verified')->count(),
                'rejected' => OrganizationProfile::where('verification_status', 'rejected')->count(),
            ],
            'events'        => [
                'total'          => Event::count(),
                'draft'          => Event::where('status', 'draft')->count(),
                'pending_review' => Event::where('status', 'pending_review')->count(),
                'published'      => Event::where('status', 'published')->count(),
                'rejected'       => Event::where('status', 'rejected')->count(),
                'completed'      => Event::where('status', 'completed')->count(),
                'cancelled'      => Event::where('status', 'cancelled')->count(),
            ],
            'registrations' => [
                'total'     => Registration::count(),
                'confirmed' => Registration::where('status', 'confirmed')->count(),
                'pending'   => Registration::where('status', 'pending')->count(),
                'cancelled' => Registration::where('status', 'cancelled')->count(),
                'attended'  => Registration::where('status', 'attended')->count(),
            ],
            'reports'       => [
                'total'        => Report::count(),
                'open'         => Report::where('status', 'open')->count(),
                'under_review' => Report::where('status', 'under_review')->count(),
                'resolved'     => Report::where('status', 'resolved')->count(),
                'dismissed'    => Report::where('status', 'dismissed')->count(),
            ],
        ]);
    }

    /**
     * GET /api/v1/admin/statistics
     * Data lengkap termasuk tren 6 bulan terakhir.
     */
    public function detailed()
    {
        // ── Statistik ringkasan ──────────────────────────────────────────
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

        // ── Tren 6 bulan terakhir ────────────────────────────────────────
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

        // Bangun array 6 bulan dengan nilai 0 untuk bulan yang kosong
        $trendLabels        = [];
        $trendData          = [];
        $eventTrendData     = [];
        $userTrendData      = [];

        for ($i = 5; $i >= 0; $i--) {
            $key              = now()->subMonths($i)->format('Y-m');
            $trendLabels[]    = $key;
            $trendData[]      = $registrationTrend[$key] ?? 0;
            $eventTrendData[] = $eventTrend[$key] ?? 0;
            $userTrendData[]  = $userTrend[$key] ?? 0;
        }

        return response()->json([
            'users'          => $users,
            'organizations'  => $organizations,
            'events'         => $events,
            'registrations'  => $registrations,
            'reports'        => $reports,
            'trend'          => [
                'labels'        => $trendLabels,
                'registrations' => $trendData,
                'events'        => $eventTrendData,
                'users'         => $userTrendData,
            ],
        ]);
    }
}