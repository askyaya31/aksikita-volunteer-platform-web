<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withInput()->with('error', 'Email atau password salah.');
        }

        if (!$user->is_active) {
            return back()->with('error', 'Akun Anda telah dinonaktifkan.');
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

    public function showRegisterVolunteer()
    {
        return view('auth.register-volunteer');
    }

    public function registerVolunteer(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed',
            'phone'                 => 'nullable|string|max:20',
            'city'                  => 'nullable|string|max:100',
            'province'              => 'nullable|string|max:100',
        ], [
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

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

        session([
            'user_id'    => $user->id,
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'user_role'  => 'volunteer',
        ]);

        return redirect()->route('volunteer.dashboard')
            ->with('success', 'Selamat datang di AksiKita!');
    }

    public function showRegisterOrganizer()
    {
        return view('auth.register-org');
    }

    public function registerOrganizer(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:8|confirmed',
            'phone'             => 'nullable|string|max:20',
            'organization_name' => 'required|string|max:255',
            'description'       => 'nullable|string',
            'city'              => 'nullable|string|max:100',
            'province'          => 'nullable|string|max:100',
        ], [
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

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
            'city'                => $request->city,
            'province'            => $request->province,
            'verification_status' => 'pending',
        ]);

        session([
            'user_id'    => $user->id,
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'user_role'  => 'organization',
        ]);

        return redirect()->route('organizer.dashboard')
            ->with('success', 'Registrasi berhasil. Akun menunggu verifikasi admin.');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}