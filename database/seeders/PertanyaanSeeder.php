<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pertanyaan;

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaans = [
            ['kategori' => 'Penguasaan Materi', 'pertanyaan' => 'Apakah dosen menguasai materi perkuliahan dengan baik?', 'urutan' => 1],
            ['kategori' => 'Cara Mengajar', 'pertanyaan' => 'Apakah dosen menjelaskan materi dengan jelas dan mudah dipahami?', 'urutan' => 2],
            ['kategori' => 'Kedisiplinan', 'pertanyaan' => 'Apakah dosen hadir sesuai jadwal perkuliahan?', 'urutan' => 3],
            ['kategori' => 'Komunikasi', 'pertanyaan' => 'Apakah dosen mampu berkomunikasi dengan baik kepada mahasiswa?', 'urutan' => 4],
            ['kategori' => 'Ketepatan Waktu', 'pertanyaan' => 'Apakah dosen memulai dan mengakhiri perkuliahan tepat waktu?', 'urutan' => 5],
            ['kategori' => 'Objektivitas', 'pertanyaan' => 'Apakah dosen memberikan penilaian secara objektif?', 'urutan' => 6],
            ['kategori' => 'Tugas', 'pertanyaan' => 'Apakah tugas yang diberikan sesuai dengan materi perkuliahan?', 'urutan' => 7],
            ['kategori' => 'Suasana Belajar', 'pertanyaan' => 'Apakah dosen menciptakan suasana belajar yang nyaman?', 'urutan' => 8],
            ['kategori' => 'Bimbingan', 'pertanyaan' => 'Apakah dosen memberikan bimbingan dengan baik?', 'urutan' => 9],
        ];

        foreach ($pertanyaans as $data) {
            Pertanyaan::create($data);
        }
    }
}
