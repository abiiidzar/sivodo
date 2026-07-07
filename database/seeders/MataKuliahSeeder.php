<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        MataKuliah::create([
            'kode' => 'MPSI-203',
            'nama' => 'Manajemen Proyek Sistem Informasi',
            'dosen_id' => 1, // Dr. Def
            'kelas' => 'A',
            'semester' => 'Genap',
        ]);

        MataKuliah::create([
            'kode' => 'KSI-303',
            'nama' => 'Keamanan Sistem Informasi',
            'dosen_id' => 2, // Dr. Ahmad
            'kelas' => 'A',
            'semester' => 'Genap',
        ]);

        MataKuliah::create([
            'kode' => 'ESI-202',
            'nama' => 'Enterprise Sistem Informasi',
            'dosen_id' => 3,
            'kelas' => 'A',
            'semester' => 'Genap',
        ]);

        MataKuliah::create([
            'kode' => 'AOK-202',
            'nama' => 'Arsitektur Operasi Komputer',
            'dosen_id' => 4,
            'kelas' => 'A',
            'semester' => 'Genap',
        ]);

        MataKuliah::create([
            'kode' => 'SBSI-203',
            'nama' => 'Strategi Bisnis Sistem Informasi',
            'dosen_id' => 5,
            'kelas' => 'A',
            'semester' => 'Genap',
        ]);
        MataKuliah::create([
            'kode' => 'SIP-2101',
            'nama' => 'Sistem Informasi Pembelajaran',
            'dosen_id' => 6,
            'kelas' => 'A',
            'semester' => 'Genap',
        ]);
        MataKuliah::create([
            'kode' => 'MLTI-302',
            'nama' => 'Manajemen Layanan Teknologi Informasi',
            'dosen_id' => 7,
            'kelas' => 'A',
            'semester' => 'Genap',
        ]);

    }
}
