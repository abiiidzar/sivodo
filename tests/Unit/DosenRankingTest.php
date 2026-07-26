<?php

namespace Tests\Unit;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Semester;
use App\Models\User;
use App\Models\Voting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DosenRankingTest extends TestCase
{
    use RefreshDatabase;

    public function test_ranking_prefers_higher_total_voting_when_average_scores_are_equal(): void
    {
        $user = User::factory()->create();
        $mahasiswaOne = Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => '202501001',
            'nama' => 'Mahasiswa 1',
            'program_studi' => 'Teknik Informatika',
            'semester' => 4,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);

        $userTwo = User::factory()->create();
        $mahasiswaTwo = Mahasiswa::create([
            'user_id' => $userTwo->id,
            'nim' => '202501002',
            'nama' => 'Mahasiswa 2',
            'program_studi' => 'Teknik Informatika',
            'semester' => 4,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);

        $semester = Semester::create([
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'status' => 'Aktif',
        ]);

        $dosenA = Dosen::create([
            'nidn' => '001',
            'nama' => 'Dosen A',
            'program_studi' => 'Teknik Informatika',
        ]);

        $dosenB = Dosen::create([
            'nidn' => '002',
            'nama' => 'Dosen B',
            'program_studi' => 'Teknik Informatika',
        ]);

        $mataKuliahA1 = MataKuliah::create([
            'kode' => 'MK001',
            'nama' => 'Pemrograman Web',
            'dosen_id' => $dosenA->id,
            'kelas' => 'A',
            'semester' => 'Ganjil',
        ]);

        $mataKuliahA2 = MataKuliah::create([
            'kode' => 'MK002',
            'nama' => 'Jaringan Komputer',
            'dosen_id' => $dosenA->id,
            'kelas' => 'A',
            'semester' => 'Ganjil',
        ]);

        $mataKuliahB = MataKuliah::create([
            'kode' => 'MK003',
            'nama' => 'Basis Data',
            'dosen_id' => $dosenB->id,
            'kelas' => 'B',
            'semester' => 'Ganjil',
        ]);

        Voting::create([
            'mahasiswa_id' => $mahasiswaOne->id,
            'dosen_id' => $dosenA->id,
            'mata_kuliah_id' => $mataKuliahA1->id,
            'semester_id' => $semester->id,
            'rata_rata' => 4.50,
        ]);

        Voting::create([
            'mahasiswa_id' => $mahasiswaTwo->id,
            'dosen_id' => $dosenA->id,
            'mata_kuliah_id' => $mataKuliahA2->id,
            'semester_id' => $semester->id,
            'rata_rata' => 4.50,
        ]);

        Voting::create([
            'mahasiswa_id' => $mahasiswaOne->id,
            'dosen_id' => $dosenB->id,
            'mata_kuliah_id' => $mataKuliahB->id,
            'semester_id' => $semester->id,
            'rata_rata' => 4.50,
        ]);

        $this->assertSame(1, $dosenA->getRanking());
        $this->assertSame(2, $dosenB->getRanking());
    }
}
