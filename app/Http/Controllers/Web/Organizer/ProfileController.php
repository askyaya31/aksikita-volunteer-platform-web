<?php
namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::find(session('user_id'));
        $org  = OrganizationProfile::where('user_id', session('user_id'))->first();

        return view('organizer.profile', compact('user', 'org'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'phone'             => 'nullable|string|max:20',
            'organization_name' => 'required|string|max:255',
            'description'       => 'nullable|string',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string|max:100',
            'province'          => 'nullable|string|max:100',
            'website'           => 'nullable|url|max:500',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'website.url' => 'Format website tidak valid. Contoh: https://organisasi.org',
        ]);

        $user = User::find(session('user_id'));
        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        $org = OrganizationProfile::where('user_id', session('user_id'))->first();

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

        $org->update($data);

        session(['user_name' => $user->name]);

        return back()->with('success', 'Profil organisasi berhasil diperbarui.');
    }
}
