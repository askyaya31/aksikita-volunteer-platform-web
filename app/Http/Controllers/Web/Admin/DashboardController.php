<?php
namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizationProfile;
use App\Models\Registration;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'          => User::count(),
            'total_volunteers'     => User::where('role', 'volunteer')->count(),
            'total_organizations'  => User::where('role', 'organization')->count(),
            'pending_org'          => OrganizationProfile::where('verification_status', 'pending')->count(),
            'total_events'         => Event::count(),
            'pending_events'       => Event::where('status', 'pending_review')->count(),
            'published_events'     => Event::where('status', 'published')->count(),
            'total_registrations'  => Registration::count(),
        ];

        $pendingOrgs = OrganizationProfile::with(['user'])
            ->where('verification_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $pendingEvents = Event::with('organization')
            ->where('status', 'pending_review')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingOrgs', 'pendingEvents'));
    }
}