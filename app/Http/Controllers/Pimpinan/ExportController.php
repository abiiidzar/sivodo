<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Voting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanDosenExport;

class ExportController extends Controller
{
    public function pdf(Request $request)
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

        $dosens = $dosens->filter(function ($dosen) {
            return $dosen->total_voting > 0;
        });

        $pdf = Pdf::loadView('pimpinan.pdf.laporan', compact('dosens'));
        return $pdf->download('laporan_evaluasi_dosen_' . date('Y-m-d') . '.pdf');
    }

    public function excel(Request $request)
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

        $dosens = $dosens->filter(function ($dosen) {
            return $dosen->total_voting > 0;
        });

        return Excel::download(new LaporanDosenExport($dosens), 'laporan_evaluasi_dosen_' . date('Y-m-d') . '.xlsx');
    }
}
