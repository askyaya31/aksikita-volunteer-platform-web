<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\OrganizationProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $org = OrganizationProfile::where('verification_status', 'verified')->first();
        if (!$org) return;

        $lingkungan = Category::where('slug', 'lingkungan')->first();
        $kesehatan  = Category::where('slug', 'kesehatan')->first();
        $pendidikan = Category::where('slug', 'pendidikan')->first();
        $sosial     = Category::where('slug', 'sosial')->first();

        $events = [
            [
                'title'         => 'Aksi Bersih Pantai Parangtritis',
                'description'   => 'Kegiatan membersihkan sampah di sepanjang Pantai Parangtritis bersama komunitas peduli lingkungan.',
                'location_name' => 'Pantai Parangtritis',
                'location_address' => 'Jl. Parangtritis, Bantul',
                'city'          => 'Bantul',
                'province'      => 'DI Yogyakarta',
                'start_date'    => now()->addDays(14)->toDateString(),
                'end_date'      => now()->addDays(14)->toDateString(),
                'start_time'    => '07:00',
                'end_time'      => '12:00',
                'quota'         => 50,
                'status'        => 'published',
                'requirements'  => 'Usia minimal 17 tahun. Membawa sarung tangan sendiri.',
                'contact_person'=> 'Budi Santoso',
                'contact_phone' => '081234567890',
                'categories'    => [$lingkungan?->id],
            ],
            [
                'title'         => 'Pelaksana Teknis Donor Darah PMI',
                'description'   => 'Membantu mengisi formulir, mengatur antrean, dan membagikan konsumsi setelah donor.',
                'location_name' => 'PMI Kota Solo',
                'location_address' => 'Jl. Yos Sudarso No.1, Solo',
                'city'          => 'Surakarta',
                'province'      => 'Jawa Tengah',
                'start_date'    => now()->addDays(7)->toDateString(),
                'end_date'      => now()->addDays(7)->toDateString(),
                'start_time'    => '08:00',
                'end_time'      => '14:00',
                'quota'         => 20,
                'status'        => 'published',
                'requirements'  => 'Berpenampilan rapi dan sopan.',
                'contact_person'=> 'Dewi Rahayu',
                'contact_phone' => '082345678901',
                'categories'    => [$kesehatan?->id],
            ],
            [
                'title'         => 'Kelas Mengajar Anak Jalanan',
                'description'   => 'Menjadi mentor belajar non-formal untuk anak-anak jalanan, bantu PR dan ajarkan kosa kata Inggris dasar.',
                'location_name' => 'Rumah Singgah Anak Mandiri',
                'location_address' => 'Jl. Mawar No.5, Yogyakarta',
                'city'          => 'Yogyakarta',
                'province'      => 'DI Yogyakarta',
                'start_date'    => now()->addDays(3)->toDateString(),
                'end_date'      => now()->addDays(3)->toDateString(),
                'start_time'    => '10:00',
                'end_time'      => '12:00',
                'quota'         => 15,
                'status'        => 'pending_review',
                'requirements'  => 'Sabar dan suka anak-anak.',
                'contact_person'=> 'Rina Wati',
                'contact_phone' => '083456789012',
                'categories'    => [$pendidikan?->id, $sosial?->id],
            ],
        ];

        foreach ($events as $e) {
            $categoryIds = array_filter($e['categories']);
            unset($e['categories']);

            $event = Event::create([
                ...$e,
                'organization_profile_id' => $org->id,
                'slug' => Str::slug($e['title']) . '-' . Str::random(6),
            ]);

            if (!empty($categoryIds)) {
                $event->categories()->attach($categoryIds);
            }
        }
    }
}