<?php
namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizationProfile;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        $org = OrganizationProfile::where('user_id', session('user_id'))->first();

        if (!$org) {
            return redirect()->route('organizer.profile')
                ->with('error', 'Lengkapi profil organisasi terlebih dahulu.');
        }

        $stats = [
            'total'         => Event::where('organization_profile_id', $org->id)->count(),
            'pending'       => Event::where('organization_profile_id', $org->id)->where('status', 'pending_review')->count(),
            'published'     => Event::where('organization_profile_id', $org->id)->where('status', 'published')->count(),
            'volunteers'    => Registration::whereHas('event', fn($q) => $q->where('organization_profile_id', $org->id))->where('status', 'confirmed')->count(),
        ];

        $recentEvents = Event::with('categories')
            ->where('organization_profile_id', $org->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('organizer.dashboard', compact('org', 'stats', 'recentEvents'));
    }
}