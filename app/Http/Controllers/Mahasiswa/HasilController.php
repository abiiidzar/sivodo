<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Voting;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::with('votings');

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nidn', 'LIKE', "%{$search}%");
        }

        // Filter by program studi
        if ($request->filled('prodi')) {
            $query->where('program_studi', $request->prodi);
        }

        $dosens = $query->get();

        // Hitung rata-rata untuk setiap dosen
        foreach ($dosens as $dosen) {
            $dosen->rata_rata = $dosen->getRataRata();
            $dosen->total_voting = $dosen->getTotalVoting();
            $dosen->kategori = $dosen->getKategori($dosen->rata_rata);
        }

        // Filter dosen yang sudah memiliki voting
        $dosens = $dosens->filter(function ($dosen) {
            return $dosen->total_voting > 0;
        })->sortByDesc('rata_rata');

        // Ambil daftar prodi untuk filter
        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        return view('mahasiswa.hasil.index', compact('dosens', 'prodiList'));
    }

    public function show($id)
    {
        $dosen = Dosen::with('votings.mahasiswa', 'votings.mataKuliah', 'votings.semester')
            ->findOrFail($id);

        $rata_rata = $dosen->getRataRata();
        $total_voting = $dosen->getTotalVoting();
        $kategori = $dosen->getKategori($rata_rata);

        return view('mahasiswa.hasil.show', compact('dosen', 'rata_rata', 'total_voting', 'kategori'));
    }
}
