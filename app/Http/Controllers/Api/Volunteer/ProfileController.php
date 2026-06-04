<?php
namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user()->load('volunteerProfile');

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'name'          => 'sometimes|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',
            'bio'           => 'nullable|string',
            'skills'        => 'nullable|array',
            'skills.*'      => 'string',
            'interests'     => 'nullable|array',
            'interests.*'   => 'string',
            'city'          => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
        ]);

        $user    = $request->user();
        $profile = $user->volunteerProfile;

        $userData = $request->only(['name', 'phone']);
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        if (!empty(array_filter($userData, fn($v) => $v !== null))) {
            $user->update($userData);
        }
        $profileData = $request->only([
            'date_of_birth', 'gender', 'bio',
            'skills', 'interests', 'city', 'province',
        ]);
        if (!empty($profileData)) {
            $profile->update($profileData);
        }

        return response()->json([
            'message' => 'Profil berhasil diupdate.',
            'user'    => new UserResource($user->fresh()->load('volunteerProfile')),
        ]);
    }
}
