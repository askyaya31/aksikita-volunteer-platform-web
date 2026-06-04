<?php
namespace Database\Seeders;

use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'      => 'Admin AksiKita',
            'email'     => 'admin@aksikita.id',
            'password'  => Hash::make('password123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);
        $orgUser1 = User::create([
            'name'     => 'TurunTangan',
            'email'    => 'org.verified@aksikita.id',
            'password' => Hash::make('password123'),
            'role'     => 'organization',
        ]);
        OrganizationProfile::create([
            'user_id'             => $orgUser1->id,
            'organization_name'   => 'TurunTangan',
            'description'         => 'Gerakan kerelawanan pemuda yang menginkubasi aktivitas berdampak.',
            'city'                => 'Jakarta',
            'province'            => 'DKI Jakarta',
            'verification_status' => 'verified',
            'verified_at'         => now(),
        ]);
        $orgUser2 = User::create([
            'name'     => 'Bintang Nusantara',
            'email'    => 'org.pending@aksikita.id',
            'password' => Hash::make('password123'),
            'role'     => 'organization',
        ]);
        OrganizationProfile::create([
            'user_id'             => $orgUser2->id,
            'organization_name'   => 'Bintang Nusantara',
            'description'         => 'Gerakan pemuda yang berfokus pada kepedulian keberagaman.',
            'city'                => 'Surabaya',
            'province'            => 'Jawa Timur',
            'verification_status' => 'pending',
        ]);
        $volunteers = [
            [
                'name'     => 'Saskya Aliya Azizah',
                'email'    => 'saskya@aksikita.id',
                'city'     => 'Surakarta',
                'province' => 'Jawa Tengah',
                'skills'   => ['Komunikasi', 'Teamwork'],
                'interests'=> ['Pendidikan', 'Lingkungan'],
            ],
            [
                'name'     => 'Mumtazah Nur Hidayati',
                'email'    => 'mumtazah@aksikita.id',
                'city'     => 'Klaten',
                'province' => 'Jawa Tengah',
                'skills'   => ['Desain', 'Fotografi'],
                'interests'=> ['Sosial', 'Seni & Budaya'],
            ],
            [
                'name'     => 'Sanny Tazkiyah',
                'email'    => 'sanny@aksikita.id',
                'city'     => 'Boyolali',
                'province' => 'Jawa Tengah',
                'skills'   => ['Medis', 'Pertolongan Pertama'],
                'interests'=> ['Kesehatan', 'Kebencanaan'],
            ],
        ];

        foreach ($volunteers as $v) {
            $user = User::create([
                'name'     => $v['name'],
                'email'    => $v['email'],
                'password' => Hash::make('password123'),
                'role'     => 'volunteer',
            ]);
            VolunteerProfile::create([
                'user_id'   => $user->id,
                'city'      => $v['city'],
                'province'  => $v['province'],
                'skills'    => $v['skills'],
                'interests' => $v['interests'],
            ]);
        }
    }
}