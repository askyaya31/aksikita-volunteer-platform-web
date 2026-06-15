<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\OrganizationProfile;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'semua');

        $users = User::with(['organizationProfile', 'volunteerProfile'])
            ->when($tab !== 'semua', fn($q) => $q->where('role', $tab === 'organisasi' ? 'organization' : 'volunteer'))
            ->when($request->search, fn($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(15);

        return view('admin.users', compact('users', 'tab'));
    }

    public function verifyOrganization(Request $request, int $id)
    {
        $request->validate([
            'action'           => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string',
        ]);

        $org = OrganizationProfile::findOrFail($id);

        if ($request->action === 'approve') {
            $org->update(['verification_status' => 'verified']);
            $message = "Selamat! Organisasi '{$org->organization_name}' Anda telah diverifikasi. Anda sekarang bisa membuat event.";
        } else {
            $org->update([
                'verification_status' => 'rejected',
                'rejection_reason'    => $request->rejection_reason,
            ]);
            $message = "Maaf, verifikasi organisasi '{$org->organization_name}' Anda ditolak. Alasan: {$request->rejection_reason}";
        }

        Notification::create([
            'user_id' => $org->user_id,
            'title'   => $request->action === 'approve' ? 'Organisasi Diverifikasi' : 'Verifikasi Ditolak',
            'message' => $message,
            'type'    => 'organization_verified',
        ]);

        return back()->with('success', 'Status organisasi berhasil diperbarui.');
    }

    public function showOrganization(int $userId)
    {
        $user = User::with([
            'organizationProfile',
            'organizationProfile.events',
        ])
        ->where('role', 'organization')
        ->findOrFail($userId);

        return view('admin.organizations.show', compact('user'));
    }

    public function showVolunteer(int $userId)
    {
        $user = User::with([
            'volunteerProfile',
            'registrations.event.organization',
        ])
        ->where('role', 'volunteer')
        ->findOrFail($userId);

        return view('admin.volunteers.show', compact('user'));
    }

    public function toggleActive(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return response()->json(['message' => 'Akun admin tidak bisa dinonaktifkan.'], 422);
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json(['message' => "Akun berhasil {$status}.", 'is_active' => $user->is_active]);
    }
}