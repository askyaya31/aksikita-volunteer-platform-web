<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\OrganizationProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\OrganizationResource;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $orgs = OrganizationProfile::with('user')
            ->when($request->status, fn($q) => $q->where('verification_status', $request->status))
            ->latest()
            ->paginate(15);

        return OrganizationResource::collection($orgs);
    }

    public function show(int $id): JsonResponse
    {
        $org = OrganizationProfile::with(['user', 'events'])->findOrFail($id);

        return response()->json([
            'organization' => new OrganizationResource($org),
        ]);
    }

    public function verify(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'action'           => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|string|max:500',
        ]);

        $org   = OrganizationProfile::findOrFail($id);
        $admin = $request->user();

        if ($request->action === 'approve') {
            $org->update([
                'verification_status' => 'verified',
                'verified_at'         => now(),
                'verified_by'         => $admin->id,
                'rejection_reason'    => null,
            ]);

            // kirim notifikasi ke organisasi bahwa akun sudah diverifikasi
            Notification::create([
                'user_id' => $org->user_id,
                'title'   => 'Organisasi Anda Telah Diverifikasi!',
                'message' => "Selamat! Organisasi {$org->organization_name} telah diverifikasi. Anda sekarang bisa membuat kegiatan.",
                'type'    => 'org_verified',
            ]);

            return response()->json(['message' => 'Organisasi berhasil diverifikasi.']);
        }

        $org->update([
            'verification_status' => 'rejected',
            'rejection_reason'    => $request->rejection_reason,
        ]);

        //kirim notifikasi ke organisasi bahwa verifikasi ditolak beserta alasannya
        Notification::create([
            'user_id' => $org->user_id,
            'title'   => 'Verifikasi Organisasi Ditolak',
            'message' => "Verifikasi organisasi {$org->organization_name} ditolak. Alasan: {$request->rejection_reason}",
            'type'    => 'org_rejected',
        ]);

        return response()->json(['message' => 'Organisasi ditolak.']);
    }
}