<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RankingExport;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $dosens = Dosen::with('votings')->get();

        $rankingData = [];
        foreach ($dosens as $dosen) {
            $rata_rata = $dosen->getRataRata();
            $total_voting = $dosen->getTotalVoting();

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

        usort($rankingData, function ($a, $b) {
            return $b->rata_rata <=> $a->rata_rata;
        });

        foreach ($rankingData as $index => $item) {
            $item->rank = $index + 1;
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

        $rankingData = array_values($rankingData);
        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        return view('pimpinan.ranking', compact('rankingData', 'prodiList'));
    }

    public function exportPdf(Request $request)
    {
        $dosens = Dosen::with('votings')->get();

        $rankingData = [];
        foreach ($dosens as $dosen) {
            $rata_rata = $dosen->getRataRata();
            $total_voting = $dosen->getTotalVoting();

            if ($total_voting > 0) {
                $rankingData[] = (object) [
                    'nama' => $dosen->nama,
                    'nidn' => $dosen->nidn,
                    'program_studi' => $dosen->program_studi,
                    'rata_rata' => $rata_rata,
                    'total_voting' => $total_voting,
                    'kategori' => $dosen->getKategori($rata_rata),
                ];
            }
        }

        usort($rankingData, function ($a, $b) {
            return $b->rata_rata <=> $a->rata_rata;
        });

        $pdf = Pdf::loadView('pimpinan.pdf.ranking', compact('rankingData'));
        return $pdf->download('ranking_dosen_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $dosens = Dosen::with('votings')->get();

        $rankingData = [];
        foreach ($dosens as $dosen) {
            $rata_rata = $dosen->getRataRata();
            $total_voting = $dosen->getTotalVoting();

            if ($total_voting > 0) {
                $rankingData[] = (object) [
                    'nama' => $dosen->nama,
                    'nidn' => $dosen->nidn,
                    'program_studi' => $dosen->program_studi,
                    'rata_rata' => $rata_rata,
                    'total_voting' => $total_voting,
                    'kategori' => $dosen->getKategori($rata_rata),
                ];
            }
        }

        usort($rankingData, function ($a, $b) {
            return $b->rata_rata <=> $a->rata_rata;
        });

        return Excel::download(new RankingExport($rankingData), 'ranking_dosen_' . date('Y-m-d') . '.xlsx');
    }
}
