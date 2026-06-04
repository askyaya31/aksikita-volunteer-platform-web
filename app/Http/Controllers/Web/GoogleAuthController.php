<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            return $this->loginAndRedirect($user);
        }
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $user->avatar ?? $googleUser->getAvatar(),
            ]);

            return $this->loginAndRedirect($user);
        }

        session([
            'google_pending' => [
                'google_id' => $googleUser->getId(),
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'avatar'    => $googleUser->getAvatar(),
            ],
        ]);

        return redirect()->route('auth.google.role');
    }

    public function showRoleSelection()
    {
        if (!session('google_pending')) {
            return redirect()->route('login')
                ->with('error', 'Sesi Google tidak ditemukan. Silakan login ulang.');
        }

        return view('auth.google-role', [
            'googleUser' => session('google_pending'),
        ]);
    }

    public function selectRole(Request $request)
    {
        $pending = session('google_pending');

        if (!$pending) {
            return redirect()->route('login')
                ->with('error', 'Sesi Google tidak ditemukan. Silakan login ulang.');
        }

        $request->validate([
            'role'              => 'required|in:volunteer,organization',
            'organization_name' => 'required_if:role,organization|nullable|string|max:255',
        ], [
            'role.required'                  => 'Pilih salah satu peran.',
            'organization_name.required_if'  => 'Nama organisasi wajib diisi.',
        ]);

        $user = User::create([
            'name'      => $pending['name'],
            'email'     => $pending['email'],
            'password'  => null,
            'role'      => $request->role,
            'avatar'    => $pending['avatar'],
            'google_id' => $pending['google_id'],
            'is_active' => true,
        ]);

        if ($request->role === 'volunteer') {
            VolunteerProfile::create([
                'user_id' => $user->id,
            ]);
        } else {
            OrganizationProfile::create([
                'user_id'             => $user->id,
                'organization_name'   => $request->organization_name,
                'verification_status' => 'pending',
            ]);
        }
        session()->forget('google_pending');

        return $this->loginAndRedirect($user);
    }

    private function loginAndRedirect(User $user)
    {
        if (!$user->is_active) {
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        session([
            'user_id'    => $user->id,
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'user_role'  => $user->role,
        ]);

        return match($user->role) {
            'volunteer'    => redirect()->route('volunteer.dashboard'),
            'organization' => redirect()->route('organizer.dashboard'),
            'admin'        => redirect()->route('admin.dashboard'),
            default        => redirect()->route('home'),
        };
    }
}
