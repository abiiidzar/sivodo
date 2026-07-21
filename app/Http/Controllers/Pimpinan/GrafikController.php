<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Voting;
use Illuminate\Http\Request;

class GrafikController extends Controller
{
    public function index()
    {
        // Data untuk chart kepuasan per dosen
        $dosens = Dosen::with('votings')
            ->get()
            ->filter(function ($dosen) {
                return $dosen->votings->count() > 0;
            })
            ->sortByDesc(function ($dosen) {
                return $dosen->getRataRata();
            })
            ->take(10);

        $chartLabels = [];
        $chartData = [];
        $chartColors = [];

        $colors = ['#1a2744', '#c9a227', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'];

        foreach ($dosens as $index => $dosen) {
            $chartLabels[] = $dosen->nama;
            $chartData[] = $dosen->getRataRata();
            $chartColors[] = $colors[$index % count($colors)];
        }

        // Data untuk distribusi voting per kategori
        $kategoriData = [
            'Sangat Memuaskan' => 0,
            'Memuaskan' => 0,
            'Puas' => 0,
            'Cukup' => 0,
            'Tidak Puas' => 0,
        ];

        $votings = Voting::all();
        foreach ($votings as $voting) {
            $kategori = $voting->getKategori();
            if (isset($kategoriData[$kategori])) {
                $kategoriData[$kategori]++;
            }
        }

        return view('pimpinan.grafik', compact('chartLabels', 'chartData', 'chartColors', 'kategoriData'));
    }

    public function data()
    {
        // API endpoint untuk data chart (jika menggunakan AJAX)
        $dosens = Dosen::with('votings')
            ->get()
            ->filter(function ($dosen) {
                return $dosen->votings->count() > 0;
            })
            ->sortByDesc(function ($dosen) {
                return $dosen->getRataRata();
            })
            ->take(10);

        $data = [];
        foreach ($dosens as $dosen) {
            $data[] = [
                'nama' => $dosen->nama,
                'rata_rata' => $dosen->getRataRata(),
                'total_voting' => $dosen->getTotalVoting(),
            ];
        }

        return response()->json($data);
    }
}
