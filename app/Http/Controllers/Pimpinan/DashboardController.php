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

        // Dosen dengan nilai tertinggi
        $dosen_terbaik = Dosen::with('votings')
            ->get()
            ->filter(function ($dosen) {
                return $dosen->votings->count() > 0;
            })
            ->sortByDesc(function ($dosen) {
                return $dosen->getRataRata();
            })
            ->first();

        // Dosen perlu pembinaan (nilai terendah)
        $dosen_perlu_pembinaan = Dosen::with('votings')
            ->get()
            ->filter(function ($dosen) {
                return $dosen->votings->count() > 0;
            })
            ->sortBy(function ($dosen) {
                return $dosen->getRataRata();
            })
            ->first();

        // Top 3 Dosen
        $top_dosen = Dosen::with('votings')
            ->get()
            ->filter(function ($dosen) {
                return $dosen->votings->count() > 0;
            })
            ->sortByDesc(function ($dosen) {
                return $dosen->getRataRata();
            })
            ->take(3);

        // Data untuk chart
        $chartLabels = [];
        $chartData = [];
        foreach ($top_dosen as $dosen) {
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
            'chartLabels',
            'chartData'
        ));
    }
}
