<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Voting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanDosenExport;
use App\Exports\LaporanMatakuliahExport;
use App\Exports\LaporanProdiExport;
use App\Exports\RankingExport;

class LaporanController extends Controller
{
    // ============ LAPORAN DOSEN ============
    public function dosen(Request $request)
    {
        $query = Dosen::with('votings');

        if ($request->filled('prodi')) {
            $query->where('program_studi', $request->prodi);
        }

        if ($request->filled('status')) {
            $query->where('status_dosen', $request->status);
        }

        $dosens = $query->get();

        foreach ($dosens as $dosen) {
            $dosen->rata_rata = $dosen->getRataRata();
            $dosen->total_voting = $dosen->getTotalVoting();
            $dosen->kategori = $dosen->getKategori($dosen->rata_rata);
        }

        if ($request->filled('filter_voting')) {
            if ($request->filter_voting == 'sudah') {
                $dosens = $dosens->filter(function ($dosen) {
                    return $dosen->total_voting > 0;
                });
            } elseif ($request->filter_voting == 'belum') {
                $dosens = $dosens->filter(function ($dosen) {
                    return $dosen->total_voting == 0;
                });
            }
        }

        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        return view('admin.laporan.dosen', compact('dosens', 'prodiList'));
    }

    public function exportPdfDosen(Request $request)
    {
        $query = Dosen::with('votings');

        if ($request->filled('prodi')) {
            $query->where('program_studi', $request->prodi);
        }

        $dosens = $query->get();

        foreach ($dosens as $dosen) {
            $dosen->rata_rata = $dosen->getRataRata();
            $dosen->total_voting = $dosen->getTotalVoting();
            $dosen->kategori = $dosen->getKategori($dosen->rata_rata);
        }

        $pdf = Pdf::loadView('admin.laporan.pdf.dosen', compact('dosens'));
        return $pdf->download('laporan_dosen_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcelDosen(Request $request)
    {
        $query = Dosen::with('votings');

        if ($request->filled('prodi')) {
            $query->where('program_studi', $request->prodi);
        }

        $dosens = $query->get();

        foreach ($dosens as $dosen) {
            $dosen->rata_rata = $dosen->getRataRata();
            $dosen->total_voting = $dosen->getTotalVoting();
            $dosen->kategori = $dosen->getKategori($dosen->rata_rata);
        }

        return Excel::download(new LaporanDosenExport($dosens), 'laporan_dosen_' . date('Y-m-d') . '.xlsx');
    }

    // ============ LAPORAN MATA KULIAH ============
    public function matakuliah(Request $request)
    {
        $query = MataKuliah::with('dosen', 'votings');

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $matakuliahs = $query->get();

        foreach ($matakuliahs as $mk) {
            $mk->total_voting = $mk->votings->count();
            $mk->rata_rata = $mk->votings->avg('rata_rata') ?? 0;
        }

        $dosens = Dosen::orderBy('nama')->get();

        return view('admin.laporan.matakuliah', compact('matakuliahs', 'dosens'));
    }

    public function exportPdfMatakuliah(Request $request)
    {
        $query = MataKuliah::with('dosen', 'votings');

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $matakuliahs = $query->get();

        foreach ($matakuliahs as $mk) {
            $mk->total_voting = $mk->votings->count();
            $mk->rata_rata = $mk->votings->avg('rata_rata') ?? 0;
        }

        $pdf = Pdf::loadView('admin.laporan.pdf.matakuliah', compact('matakuliahs'));
        return $pdf->download('laporan_matakuliah_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcelMatakuliah(Request $request)
    {
        $query = MataKuliah::with('dosen', 'votings');

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $matakuliahs = $query->get();

        foreach ($matakuliahs as $mk) {
            $mk->total_voting = $mk->votings->count();
            $mk->rata_rata = $mk->votings->avg('rata_rata') ?? 0;
        }

        return Excel::download(new LaporanMatakuliahExport($matakuliahs), 'laporan_matakuliah_' . date('Y-m-d') . '.xlsx');
    }

    // ============ LAPORAN PROGRAM STUDI ============
    public function prodi(Request $request)
    {
        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        $data = [];
        foreach ($prodiList as $prodi) {
            $dosens = Dosen::where('program_studi', $prodi)->with('votings')->get();

            $total_dosen = $dosens->count();
            $total_voting = 0;
            $total_rata = 0;
            $dosen_with_voting = 0;

            foreach ($dosens as $dosen) {
                $voting_count = $dosen->votings->count();
                $total_voting += $voting_count;
                if ($voting_count > 0) {
                    $total_rata += $dosen->getRataRata();
                    $dosen_with_voting++;
                }
            }

            $data[] = (object) [
                'program_studi' => $prodi,
                'total_dosen' => $total_dosen,
                'total_voting' => $total_voting,
                'rata_rata' => $dosen_with_voting > 0 ? round($total_rata / $dosen_with_voting, 2) : 0,
                'dosen_with_voting' => $dosen_with_voting,
            ];
        }

        return view('admin.laporan.prodi', compact('data'));
    }

    public function exportPdfProdi(Request $request)
    {
        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        $data = [];
        foreach ($prodiList as $prodi) {
            $dosens = Dosen::where('program_studi', $prodi)->with('votings')->get();

            $total_dosen = $dosens->count();
            $total_voting = 0;
            $total_rata = 0;
            $dosen_with_voting = 0;

            foreach ($dosens as $dosen) {
                $voting_count = $dosen->votings->count();
                $total_voting += $voting_count;
                if ($voting_count > 0) {
                    $total_rata += $dosen->getRataRata();
                    $dosen_with_voting++;
                }
            }

            $data[] = (object) [
                'program_studi' => $prodi,
                'total_dosen' => $total_dosen,
                'total_voting' => $total_voting,
                'rata_rata' => $dosen_with_voting > 0 ? round($total_rata / $dosen_with_voting, 2) : 0,
                'dosen_with_voting' => $dosen_with_voting,
            ];
        }

        $pdf = Pdf::loadView('admin.laporan.pdf.prodi', compact('data'));
        return $pdf->download('laporan_prodi_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcelProdi(Request $request)
    {
        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        $data = [];
        foreach ($prodiList as $prodi) {
            $dosens = Dosen::where('program_studi', $prodi)->with('votings')->get();

            $total_dosen = $dosens->count();
            $total_voting = 0;
            $total_rata = 0;
            $dosen_with_voting = 0;

            foreach ($dosens as $dosen) {
                $voting_count = $dosen->votings->count();
                $total_voting += $voting_count;
                if ($voting_count > 0) {
                    $total_rata += $dosen->getRataRata();
                    $dosen_with_voting++;
                }
            }

            $data[] = (object) [
                'program_studi' => $prodi,
                'total_dosen' => $total_dosen,
                'total_voting' => $total_voting,
                'rata_rata' => $dosen_with_voting > 0 ? round($total_rata / $dosen_with_voting, 2) : 0,
                'dosen_with_voting' => $dosen_with_voting,
            ];
        }

        return Excel::download(new LaporanProdiExport($data), 'laporan_prodi_' . date('Y-m-d') . '.xlsx');
    }

    // ============ GRAFIK & RANKING ============
    public function grafik()
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

        $chartLabels = array_slice(array_map(function ($item) {
            return $item->nama;
        }, $rankingData), 0, 10);

        $chartData = array_slice(array_map(function ($item) {
            return $item->rata_rata;
        }, $rankingData), 0, 10);

        return view('admin.laporan.grafik', compact('rankingData', 'chartLabels', 'chartData'));
    }

    public function exportPdfRanking(Request $request)
    {
        $dosens = Dosen::with('votings')->get();

        $rankingData = [];
        foreach ($dosens as $dosen) {
            $rata_rata = $dosen->getRataRata();
            $total_voting = $dosen->getTotalVoting();

            if ($total_voting > 0) {
                $rankingData[] = (object) [
                    'nama' => $dosen->nama,
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

        foreach ($rankingData as $index => $item) {
            $item->rank = $index + 1;
        }

        $pdf = Pdf::loadView('admin.laporan.pdf.ranking', compact('rankingData'));
        return $pdf->download('ranking_dosen_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcelRanking(Request $request)
    {
        $dosens = Dosen::with('votings')->get();

        $rankingData = [];
        foreach ($dosens as $dosen) {
            $rata_rata = $dosen->getRataRata();
            $total_voting = $dosen->getTotalVoting();

            if ($total_voting > 0) {
                $rankingData[] = (object) [
                    'nama' => $dosen->nama,
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

        foreach ($rankingData as $index => $item) {
            $item->rank = $index + 1;
        }

        return Excel::download(new RankingExport($rankingData), 'ranking_dosen_' . date('Y-m-d') . '.xlsx');
    }
}
