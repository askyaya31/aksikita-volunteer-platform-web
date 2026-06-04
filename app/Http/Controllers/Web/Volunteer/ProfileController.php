<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::with('volunteerProfile')->find(session('user_id'));
        return view('volunteer.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',
            'bio'           => 'nullable|string|max:500',
            'city'          => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
            'skills'        => 'nullable|string',
            'interests'     => 'nullable|string',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = User::find(session('user_id'));
        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        $profile = $user->volunteerProfile;

        $data = $request->only([
            'date_of_birth', 'gender', 'bio', 'city', 'province',
        ]);

        if ($request->filled('skills')) {
            $data['skills'] = array_map('trim', explode(',', $request->skills));
        }
        if ($request->filled('interests')) {
            $data['interests'] = array_map('trim', explode(',', $request->interests));
        }

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->update($data);
        session(['user_name' => $user->name]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
