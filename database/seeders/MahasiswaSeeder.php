<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::create([
            'user_id' => 3, // ID user Annisa
            'nim' => '235720111006',
            'nama' => 'Annisa Dwi Putri',
            'program_studi' => 'Sistem Informasi',
            'semester' => 6,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);

        Mahasiswa::create([
            'user_id' => 4, // ID user Raffi Dwika
            'nim' => '235720111019',
            'nama' => 'Mohammad Raffi Dwika',
            'program_studi' => 'Sistem Informasi',
            'semester' => 6,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);
        Mahasiswa::create([
            'user_id' => 5, // ID user Abidzar Al Ghiffari
            'nim' => '235720111020',
            'nama' => 'Abidzar Al Ghiffari',
            'program_studi' => 'Sistem Informasi',
            'semester' => 6,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);
        Mahasiswa::create([
            'user_id' => 6, // ID user Hafizah Faraz
            'nim' => '235720111024',
            'nama' => 'Hafizah Faraz',
            'program_studi' => 'Sistem Informasi',
            'semester' => 6,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);
        Mahasiswa::create([
            'user_id' => 7, // ID user Rindiani Fatika Sari
            'nim' => '235720111058',
            'nama' => 'Rindiani Fatika Sari',
            'program_studi' => 'Sistem Informasi',
            'semester' => 6,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);
    }
}
