<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $semesterAktif = Semester::getSemesterAktif();

        // Ambil daftar dosen yang mengajar di semester aktif
        $dosens = Dosen::whereHas('mataKuliahs', function ($query) use ($semesterAktif) {
            $query->where('semester', $semesterAktif->semester ?? 'Ganjil');
        })->get();

        // Cek status voting per dosen
        $statusVoting = [];
        foreach ($dosens as $dosen) {
            $statusVoting[$dosen->id] = Voting::where('mahasiswa_id', $mahasiswa->id)
                ->where('dosen_id', $dosen->id)
                ->where('semester_id', $semesterAktif->id ?? 0)
                ->exists();
        }

        return view('mahasiswa.dashboard', compact(
            'mahasiswa',
            'dosens',
            'statusVoting',
            'semesterAktif'
        ));
    }
}
