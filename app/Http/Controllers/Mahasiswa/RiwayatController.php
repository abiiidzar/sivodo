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

        $query = Voting::with(['dosen', 'mataKuliah', 'semester'])
            ->where('mahasiswa_id', $mahasiswa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('dosen', function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%");
            });
        }

        $votings = $query->latest()->paginate(10);
        $votings->appends($request->all());

        // TAMBAHKAN KATEGORI KE SETIAP VOTING
        foreach ($votings as $voting) {
            $voting->kategori = $this->getKategori($voting->rata_rata);
        }

        return view('mahasiswa.riwayat.index', compact('votings'));
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
        if ($rataRata >= 4.50) return ['label' => 'Sangat Memuaskan', 'class' => 'bg-emerald-500'];
        if ($rataRata >= 4.00) return ['label' => 'Memuaskan', 'class' => 'bg-blue-500'];
        if ($rataRata >= 3.00) return ['label' => 'Puas', 'class' => 'bg-yellow-500'];
        if ($rataRata >= 2.00) return ['label' => 'Cukup', 'class' => 'bg-orange-500'];
        return ['label' => 'Tidak Puas', 'class' => 'bg-red-500'];
    }
}
