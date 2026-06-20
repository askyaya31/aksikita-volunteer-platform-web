<?php

namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\OrganizationProfile;
use App\Models\Registration;

class CandidateController extends Controller
{
    private function getOrg()
    {
        return OrganizationProfile::where('user_id', session('user_id'))->first();
    }

    public function index(Request $request)
    {
        $org   = $this->getOrg();
        $orgId = $org?->id;

        $events = Event::where('organization_profile_id', $orgId)
            ->orderByDesc('start_date')
            ->get(['id', 'title', 'start_date']);

        $eventId       = $request->get('event');
        $selectedEvent = $eventId ? $events->firstWhere('id', (int) $eventId) : null;
        $statusFilter  = $request->get('status');

        $candidates = Registration::whereHas('event', function ($q) use ($orgId) {
                $q->where('organization_profile_id', $orgId);
            })
            ->when($eventId, fn ($q) => $q->where('event_id', $eventId))
            ->when($statusFilter, fn ($q) => $q->where('status', $statusFilter))
            ->with(['user.volunteerProfile', 'event'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('organizer.events.candidates',
            compact('org', 'candidates', 'events', 'selectedEvent', 'statusFilter'));
    }

    public function show($registrationId)
    {
        $org   = $this->getOrg();
        $orgId = $org?->id;

        $candidate = Registration::whereHas('event', function ($q) use ($orgId) {
                $q->where('organization_profile_id', $orgId);
            })
            ->with(['user.volunteerProfile', 'event'])
            ->findOrFail($registrationId);

        return view('organizer.events.candidate-detail', compact('org', 'candidate'));
    }
}