<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $dosens = Dosen::with('votings')->get();

        // Hitung rata-rata untuk setiap dosen
        $rankingData = [];
        foreach ($dosens as $dosen) {
            $rata_rata = $dosen->getRataRata();
            $total_voting = $dosen->getTotalVoting();

            // Hanya dosen yang memiliki voting
            if ($total_voting > 0) {
                $rankingData[] = (object) [
                    'id' => $dosen->id,
                    'nama' => $dosen->nama,
                    'nidn' => $dosen->nidn,
                    'program_studi' => $dosen->program_studi,
                    'foto' => $dosen->foto,
                    'rata_rata' => $rata_rata,
                    'total_voting' => $total_voting,
                    'kategori' => $dosen->getKategori($rata_rata),
                ];
            }
        }

        // Sort by rata-rata descending
        usort($rankingData, function ($a, $b) {
            return $b->rata_rata <=> $a->rata_rata;
        });

        // Add rank
        foreach ($rankingData as $index => $item) {
            $item->rank = $index + 1;
            // Add medal icon for top 3
            if ($index == 0) $item->medal = '🥇';
            elseif ($index == 1) $item->medal = '🥈';
            elseif ($index == 2) $item->medal = '🥉';
            else $item->medal = $index + 1;
        }

        // Filter by prodi
        if ($request->filled('prodi')) {
            $rankingData = array_filter($rankingData, function ($item) use ($request) {
                return $item->program_studi == $request->prodi;
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $rankingData = array_filter($rankingData, function ($item) use ($search) {
                return stripos($item->nama, $search) !== false ||
                       stripos($item->nidn, $search) !== false;
            });
        }

        $rankingData = array_values($rankingData);
        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        return view('mahasiswa.ranking.index', compact('rankingData', 'prodiList'));
    }

    public function exportPdf()
    {
        // TODO: Export PDF
        return redirect()->back()->with('info', 'Fitur export PDF dalam pengembangan');
    }
}
