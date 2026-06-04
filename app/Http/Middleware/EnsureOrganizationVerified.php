<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOrganizationVerified
{
    public function handle(Request $request, Closure $next): mixed
    {
        $org = $request->user()?->organizationProfile;

        if (!$org) {
            return response()->json([
                'message'             => 'Profil organisasi tidak ditemukan. Silakan lengkapi pendaftaran.',
                'verification_status' => 'not_registered',
            ], 403);
        }

        if ($org->verification_status !== 'verified') {
            return response()->json([
                'message'             => 'Organisasi Anda belum diverifikasi. Silakan tunggu verifikasi admin.',
                'verification_status' => $org->verification_status,
            ], 403);
        }

        return $next($request);
    }
}
