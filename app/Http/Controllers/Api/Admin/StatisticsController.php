<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizationProfile;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'total_users'         => User::count(),
            'total_volunteers'    => User::where('role', 'volunteer')->count(),
            'total_organizations' => User::where('role', 'organization')->count(),
            'pending_orgs'        => OrganizationProfile::where('verification_status', 'pending')->count(),
            'total_events'        => Event::count(),
            'pending_events'      => Event::where('status', 'pending_review')->count(),
            'published_events'    => Event::where('status', 'published')->count(),
            'total_registrations' => Registration::count(),
        ]);
    }

    public function detailed(): JsonResponse
    {
        return response()->json([
            'users' => [
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
            'events' => [
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
        ]);
    }
}