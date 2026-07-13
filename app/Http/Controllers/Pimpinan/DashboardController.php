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


        // Dosen terbaik (top 3)
        $dosenTerbaik = Dosen::withCount('votings')
            ->withAvg('votings', 'rata_rata')
            ->orderByDesc('votings_avg_rata_rata')
            ->limit(3)
            ->get();

        // Dosen perlu pembinaan (bottom 3 dengan minimal 5 voting)
        $dosenPerluPembinaan = Dosen::withCount('votings')
            ->withAvg('votings', 'rata_rata')
            ->having('votings_count', '>=', 5)
            ->orderBy('votings_avg_rata_rata')
            ->limit(3)
            ->get();

        $data = [
            'total_voting' => Voting::count(),
            'rata_rata_kepuasan' => Voting::avg('rata_rata') ?? 0,
            'dosen_terbaik' => $dosenTerbaik,
            'dosen_perlu_pembinaan' => $dosenPerluPembinaan,
            'total_mahasiswa_voting' => Voting::distinct('mahasiswa_id')->count(),
        ];

        return view('pimpinan.dashboard', compact(
            'totalVoting',
            'totalMahasiswaVoting',
            'rataRataKepuasan',
            'dosenTerbaik',
            'dosenPerluPembinaan','data'
        ));
    }
}
