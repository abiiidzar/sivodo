<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Voting;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return redirect()->route('pimpinan.laporan.dosen');
    }

    public function dosen(Request $request)
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

        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        return view('pimpinan.laporan.dosen', compact('dosens', 'prodiList'));
    }

    public function matakuliah(Request $request)
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

        $matakuliahs = $matakuliahs->filter(function ($mk) {
            return $mk->total_voting > 0;
        });

        return view('pimpinan.laporan.matakuliah', compact('matakuliahs'));
    }

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

        return view('pimpinan.laporan.prodi', compact('data'));
    }
}
