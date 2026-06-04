<?php
namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\OrganizationResource;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user()->load('organizationProfile');
        $org  = $user->organizationProfile;

        return response()->json([
            'organization' => new OrganizationResource($org->loadMissing('user')),
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'name'              => 'sometimes|string|max:255',
            'phone'             => 'nullable|string|max:20',
            'organization_name' => 'sometimes|string|max:255',
            'description'       => 'nullable|string',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string|max:100',
            'province'          => 'nullable|string|max:100',
            'website'           => 'nullable|url|max:500',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'document'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = $request->user();
        $org  = $user->organizationProfile;
        $userData = $request->only(['name', 'phone']);
        if (!empty(array_filter($userData, fn($v) => $v !== null))) {
            $user->update($userData);
        }

        $data = $request->only([
            'organization_name', 'description', 'address',
            'city', 'province', 'website',
        ]);

        if ($request->hasFile('logo')) {
            if ($org->logo) {
                Storage::disk('public')->delete($org->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('document')) {
            if ($org->document_path) {
                Storage::disk('public')->delete($org->document_path);
            }
            $data['document_path'] = $request->file('document')->store('documents', 'public');
        }

        $org->update($data);

        return response()->json([
            'message'      => 'Profil organisasi berhasil diupdate.',
            'organization' => new OrganizationResource($org->loadMissing('user')),
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
        ]);
    }
}
