<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Voting;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // === STATISTIK UTAMA ===
        $totalVoting = Voting::count();
        $totalMahasiswaVoting = Voting::distinct('mahasiswa_id')->count();
        $rataRataKepuasan = Voting::avg('rata_rata') ?? 0;
        $totalDosen = Dosen::count();

        // === DOSEN TERBAIK (TOP 3) ===
        $dosenTerbaik = Dosen::withCount('votings')
            ->withAvg('votings', 'rata_rata')
            ->having('votings_count', '>=', 1)
            ->orderByDesc('votings_avg_rata_rata')
            ->limit(3)
            ->get();

        // === DOSEN PERLU PEMBINAAN (BOTTOM 3) ===
        $dosenPerluPembinaan = Dosen::withCount('votings')
            ->withAvg('votings', 'rata_rata')
            ->having('votings_count', '>=', 5)  // Minimal 5 voting agar valid
            ->orderBy('votings_avg_rata_rata')
            ->limit(3)
            ->get();

        // === TOP 3 DOSEN UNTUK SIDEBAR (sama dengan dosenTerbaik) ===
        $topDosen = $dosenTerbaik;

        // === KIRIM KE VIEW ===
        return view('pimpinan.dashboard', compact(
            'totalVoting',
            'totalMahasiswaVoting',
            'rataRataKepuasan',
            'totalDosen',
            'dosenTerbaik',
            'dosenPerluPembinaan',
            'topDosen'
        ));
    }
}
