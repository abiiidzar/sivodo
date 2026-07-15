<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Dosen;
use App\Models\Voting;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // === SEMESTER AKTIF ===
        $semesterAktif = Semester::getSemesterAktif();

        // === AMBIL DOSEN YANG MENGAJAR DI SEMESTER AKTIF ===
        $dosens = Dosen::whereHas('mataKuliahs', function ($query) use ($semesterAktif) {
            $query->where('semester', $semesterAktif->semester ?? 'Ganjil');
        })->get();

        // === HITUNG STATISTIK ===
        $total_dosen = $dosens->count();

        $sudah_voting = 0;
        $statusVoting = [];
        foreach ($dosens as $dosen) {
            $sudah = Voting::where('mahasiswa_id', $mahasiswa->id)
                ->where('dosen_id', $dosen->id)
                ->where('semester_id', $semesterAktif->id ?? 0)
                ->exists();

            $statusVoting[$dosen->id] = $sudah;

            if ($sudah) {
                $sudah_voting++;
            }
        }

        $belum_voting = $total_dosen - $sudah_voting;
        $progress = $total_dosen > 0 ? round(($sudah_voting / $total_dosen) * 100) : 0;

        return view('mahasiswa.dashboard', compact(
            'mahasiswa',
            'dosens',
            'statusVoting',
            'semesterAktif',
            'total_dosen',
            'sudah_voting',
            'belum_voting',
            'progress'
        ));
    }
}
