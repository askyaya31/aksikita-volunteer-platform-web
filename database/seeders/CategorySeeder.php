<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lingkungan',    'color' => '#22C55E', 'icon' => 'leaf'],
            ['name' => 'Pendidikan',    'color' => '#3B82F6', 'icon' => 'book'],
            ['name' => 'Kesehatan',     'color' => '#EF4444', 'icon' => 'heart'],
            ['name' => 'Sosial',        'color' => '#F59E0B', 'icon' => 'users'],
            ['name' => 'Kebencanaan',   'color' => '#8B5CF6', 'icon' => 'alert-triangle'],
            ['name' => 'Seni & Budaya', 'color' => '#EC4899', 'icon' => 'palette'],
            ['name' => 'Olahraga',      'color' => '#F97316', 'icon' => 'activity'],
            ['name' => 'Teknologi',     'color' => '#06B6D4', 'icon' => 'cpu'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'  => $cat['name'],
                'slug'  => Str::slug($cat['name']),
                'color' => $cat['color'],
                'icon'  => $cat['icon'],
            ]);
        }
    }
}