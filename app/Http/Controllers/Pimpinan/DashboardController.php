<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Voting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $total_voting = Voting::count();
        $rata_rata_kepuasan = Voting::avg('rata_rata') ?? 0;
        $total_mahasiswa_voting = Voting::distinct('mahasiswa_id')->count();
        $total_dosen = Dosen::count();

        $sortedDosen = Dosen::sortByRanking(Dosen::with('votings')->get());

        // Ambil dosen yang SUDAH memiliki voting saja
        $dosenDenganVoting = $sortedDosen->filter(function ($dosen) {
            return $dosen->getTotalVoting() > 0;
        });


        // Dosen dengan nilai tertinggi
        $dosen_terbaik = $dosenDenganVoting->first();

        // Dosen perlu pembinaan (nilai terendah)
        $dosen_perlu_pembinaan = $dosenDenganVoting->last();

        // Top 3 Dosen
        $top_dosen = $sortedDosen->take(3);

        $rankingData = $sortedDosen->take(3);

        foreach ($rankingData as $index => $item) {
            $item->rank = $index + 1;
            if ($index == 0) $item->medal = '🥇';
            elseif ($index == 1) $item->medal = '🥈';
            elseif ($index == 2) $item->medal = '🥉';
            else $item->medal = $index + 1;
        }
        // Data untuk chart
        $chartLabels = [];
        $chartData = [];
        foreach ($top_dosen as $dosen) {
            $chartLabels[] = $dosen->nama;
            $chartData[] = $dosen->getRataRata();
        }
        foreach ($rankingData as $dosen) {
            $chartLabels[] = $dosen->nama;
            $chartData[] = $dosen->getRataRata();
        }

        return view('pimpinan.dashboard', compact(
            'total_voting',
            'rata_rata_kepuasan',
            'total_mahasiswa_voting',
            'total_dosen',
            'dosen_terbaik',
            'dosen_perlu_pembinaan',
            'top_dosen',
            'rankingData',
            'chartLabels',
            'chartData'
        ));
    }
}
