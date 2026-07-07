<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = [
            [
                'nidn' => '1234567890',
                'nama' => 'Defriany, M.Kom.',
                'program_studi' => 'Sistem Informasi',
                'status_dosen' => 'PNS',
                'foto' => null,
            ],
            [
                'nidn' => '2345678901',
                'nama' => 'Ilham Tri Maulana, M.Pd.T CITAP',
                'program_studi' => 'Sistem Informasi',
                'status_dosen' => 'PNS',
                'foto' => null,
            ],
            [
                'nidn' => '3456789012',
                'nama' => 'Monanda Rio Meta, M.Pd.T.',
                'program_studi' => 'Sistem Informasi',
                'status_dosen' => 'PNS',
                'foto' => null,
            ],
            [
                'nidn' => '4567890123',
                'nama' => 'Nency Extise Putri, M.Kom.',
                'program_studi' => 'Sistem Informasi',
                'status_dosen' => 'Luar Biasa',
                'foto' => null,
            ],
            [
                'nidn' => '5678901234',
                'nama' => 'Rifa Turaina, M.Kom.',
                'program_studi' => 'Sistem Informasi',
                'status_dosen' => 'Yayasan',
                'foto' => null,
            ],
            [
                'nidn' => '6789012345',
                'nama' => 'Dr. Sri Restu Ningsih, M.Kom.',
                'program_studi' => 'Sistem Informasi',
                'status_dosen' => 'Yayasan',
                'foto' => null,
            ],
            [
                'nidn' => '7890123456',
                'nama' => 'Zainul Efendi, M.Kom.',
                'program_studi' => 'Sistem Informasi',
                'status_dosen' => 'Yayasan',
                'foto' => null,
            ],
        ];

        foreach ($dosens as $data) {
            Dosen::create($data);
        }
    }
}
