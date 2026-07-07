<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        Semester::create([
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'status' => 'Tidak Aktif',
        ]);

        Semester::create([
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Genap',
            'status' => 'Aktif',
        ]);
    }
}
