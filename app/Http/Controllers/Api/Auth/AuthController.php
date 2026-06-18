<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterOrganizationRequest;
use App\Http\Requests\Auth\RegisterVolunteerRequest;
use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function registerVolunteer(RegisterVolunteerRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'volunteer',
            'phone'    => $request->phone,
        ]);

        VolunteerProfile::create([
            'user_id'  => $user->id,
            'city'     => $request->city,
            'province' => $request->province,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Registrasi volunteer berhasil.',
            'token'   => $token,
            'user'    => new UserResource($user->load('volunteerProfile')),
        ], 201);
    }

    public function registerOrganization(RegisterOrganizationRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'organization',
            'phone'    => $request->phone,
        ]);

        OrganizationProfile::create([
            'user_id'             => $user->id,
            'organization_name'   => $request->organization_name,
            'description'         => $request->description,
            'address'             => $request->address,
            'city'                => $request->city,
            'province'            => $request->province,
            'verification_status' => 'pending',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi organisasi berhasil. Menunggu verifikasi admin.',
            'token'   => $token,
            'user'    => new UserResource($user->load('organizationProfile')),
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Akun Anda telah dinonaktifkan.'], 403);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token'   => $token,
            'role'    => $user->role,
            'user'    => new UserResource($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->isOrganization()) {
            $user->load('organizationProfile');
        } elseif ($user->isVolunteer()) {
            $user->load('volunteerProfile');
        }
        return response()->json([
            'user' => new UserResource($user),
        ]);
    }
}