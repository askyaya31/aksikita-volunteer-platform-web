<?php
namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\Registration;

class VolunteerController extends Controller
{
    private function getOrg(): OrganizationProfile
    {
        return OrganizationProfile::where('user_id', session('user_id'))->firstOrFail();
    }
    public function show(int $registrationId)
    {
        $org = $this->getOrg();

        $registration = Registration::with([
            'event',
            'user.volunteerProfile',
            'user.registrations.event:id,title,start_date,city,status',
        ])
        ->whereHas('event', fn($q) => $q->where('organization_profile_id', $org->id))
        ->findOrFail($registrationId);

        $volunteer = $registration->user;
        $profile   = $volunteer->volunteerProfile;

        $history = $volunteer->registrations
            ->whereIn('status', ['confirmed', 'attended', 'cancelled'])
            ->sortByDesc('registered_at');

        $stats = [
            'total_daftar'    => $volunteer->registrations->count(),
            'total_hadir'     => $volunteer->registrations->where('status', 'attended')->count(),
            'total_confirmed' => $volunteer->registrations->where('status', 'confirmed')->count(),
            'total_batal'     => $volunteer->registrations->where('status', 'cancelled')->count(),
        ];

        return view('organizer.volunteers.show', compact(
            'registration',
            'volunteer',
            'profile',
            'history',
            'stats',
            'org'
        ));
    }
}