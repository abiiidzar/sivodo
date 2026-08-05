<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $query = Voting::with(['dosen', 'mataKuliah', 'semester', 'mahasiswa'])
            ->where('mahasiswa_id', $mahasiswa->id);

        // Search by dosen name or NIDN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('dosen', function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nidn', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('semester')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        // Urutkan berdasarkan nilai tertinggi ke terendah
        $query->orderBy('rata_rata', 'DESC');

        $votings = $query->paginate(10);
        $votings->appends($request->all());

        // Tambahkan kategori ke setiap voting
        foreach ($votings as $voting) {
            $voting->kategori = $this->getKategori($voting->rata_rata);
        }

        // Ambil daftar semester mahasiswa (1-14) untuk filter
        $semesterList = range(1, 14);

        return view('mahasiswa.riwayat.index', compact('votings', 'semesterList'));
    }

    public function show($id)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $voting = Voting::with(['dosen', 'mataKuliah', 'semester', 'votingDetails.pertanyaan'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->findOrFail($id);

        $kategori = $this->getKategori($voting->rata_rata);

        return view('mahasiswa.riwayat.show', compact('voting', 'kategori'));
    }

    private function getKategori($rataRata)
    {
        if ($rataRata >= 3.50) return ['label' => 'Sangat Memuaskan', 'class' => 'bg-emerald-500'];
        if ($rataRata >= 3.00) return ['label' => 'Memuaskan', 'class' => 'bg-blue-500'];
        if ($rataRata >= 2.50) return ['label' => 'Puas', 'class' => 'bg-yellow-500'];
        if ($rataRata >= 2.00) return ['label' => 'Cukup', 'class' => 'bg-orange-500'];
        return ['label' => 'Tidak Puas', 'class' => 'bg-red-500'];
    }
}
