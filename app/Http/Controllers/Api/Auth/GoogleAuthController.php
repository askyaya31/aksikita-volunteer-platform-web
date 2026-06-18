<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $payload = $this->verifyGoogleToken($request->id_token);

        if (!$payload) {
            return response()->json([
                'message' => 'Token Google tidak valid atau sudah kadaluarsa.',
            ], 401);
        }

        $googleId = $payload['sub'];       
        $email    = $payload['email'];
        $name     = $payload['name']     ?? 'User';
        $avatar   = $payload['picture']  ?? null;

        
        $user = User::where('google_id', $googleId)->first();

        if ($user) {
            return $this->issueToken($user);
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'google_id' => $googleId,
                'avatar'    => $user->avatar ?? $avatar,
            ]);

            return $this->issueToken($user);
        }

        $user = User::create([
            'name'      => $name,
            'email'     => $email,
            'password'  => null,                  
            'role'      => 'volunteer',
            'avatar'    => $avatar,
            'google_id' => $googleId,
            'is_active' => true,
        ]);

        VolunteerProfile::create([
            'user_id' => $user->id,
        ]);

        return $this->issueToken($user, 201);
    }
    private function verifyGoogleToken(string $idToken): ?array
    {
        try {
          
            $url      = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);
            $response = file_get_contents($url);

            if ($response === false) {
                return null;
            }

            $payload = json_decode($response, true);

            $validClientIds = [
                config('services.google.client_id'),         
                config('services.google.android_client_id'),
            ];

            if (!in_array($payload['aud'] ?? '', array_filter($validClientIds))) {
                Log::warning('Google token aud mismatch', [
                    'aud'      => $payload['aud'] ?? null,
                    'expected' => $validClientIds,
                ]);
                return null;
            }

            if (($payload['email_verified'] ?? 'false') !== 'true') {
                return null;
            }

            return $payload;

        } catch (\Exception $e) {
            Log::error('Google token verification failed: ' . $e->getMessage());
            return null;
        }
    }
    private function issueToken(User $user, int $status = 200): JsonResponse
    {
        if (!$user->is_active) {
            return response()->json([
                'message' => 'Akun Anda telah dinonaktifkan.',
            ], 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('google-auth')->plainTextToken;

        if ($user->isVolunteer()) {
            $user->load('volunteerProfile');
        } elseif ($user->isOrganization()) {
            $user->load('organizationProfile');
        }

        return response()->json([
            'message' => 'Login dengan Google berhasil.',
            'token'   => $token,
            'role'    => $user->role,
            'user'    => new UserResource($user),
        ], $status);
    }
}