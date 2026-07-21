<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Semester;
use App\Models\Pertanyaan;
use App\Models\Voting;
use App\Models\VotingDetail;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    // Halaman daftar dosen untuk voting
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $semesterAktif = Semester::where('status', 'Aktif')->first();

        if (!$semesterAktif) {
            return view('mahasiswa.voting.index', [
                'dosens' => collect(),
                'semesterAktif' => null,
                'mahasiswa' => $mahasiswa,
                'message' => 'Belum ada semester aktif. Silahkan tunggu admin mengaktifkan semester.'
            ]);
        }

        // Ambil semua dosen yang memiliki mata kuliah di semester aktif
        $dosens = Dosen::whereHas('mataKuliahs', function ($query) use ($semesterAktif) {
            $query->where('semester', $semesterAktif->semester);
        })->with(['mataKuliahs' => function ($query) use ($semesterAktif) {
            $query->where('semester', $semesterAktif->semester);
        }])->get();

        // Cek status voting per dosen
        foreach ($dosens as $dosen) {
            $dosen->sudahVoting = Voting::where('mahasiswa_id', $mahasiswa->id)
                ->where('dosen_id', $dosen->id)
                ->where('semester_id', $semesterAktif->id)
                ->exists();
        }

        return view('mahasiswa.voting.index', compact('dosens', 'semesterAktif', 'mahasiswa'));
    }

    // Halaman form voting untuk dosen tertentu
    public function create($dosenId)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $semesterAktif = Semester::where('status', 'Aktif')->first();

        if (!$semesterAktif) {
            return redirect()->route('mahasiswa.voting')
                ->with('error', 'Belum ada semester aktif.');
        }

        // Cek apakah sudah voting
        $sudahVoting = Voting::where('mahasiswa_id', $mahasiswa->id)
            ->where('dosen_id', $dosenId)
            ->where('semester_id', $semesterAktif->id)
            ->exists();

        if ($sudahVoting) {
            return redirect()->route('mahasiswa.voting')
                ->with('error', 'Anda sudah memberikan penilaian untuk dosen ini.');
        }

        $dosen = Dosen::with(['mataKuliahs' => function ($query) use ($semesterAktif) {
            $query->where('semester', $semesterAktif->semester);
        }])->findOrFail($dosenId);

        $pertanyaans = Pertanyaan::where('status', true)
            ->orderBy('urutan')
            ->get();

        if ($pertanyaans->count() == 0) {
            return redirect()->route('mahasiswa.voting')
                ->with('error', 'Belum ada pertanyaan kuisioner. Silahkan hubungi admin.');
        }

        return view('mahasiswa.voting.create', compact('dosen', 'pertanyaans', 'semesterAktif', 'mahasiswa'));
    }

    // Proses simpan voting
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'nilai' => 'required|array|min:1',
            'nilai.*' => 'required|integer|min:1|max:5',
            'kritik' => 'nullable|string',
            'saran' => 'nullable|string',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        $semesterAktif = Semester::where('status', 'Aktif')->first();

        if (!$semesterAktif) {
            return redirect()->route('mahasiswa.voting')
                ->with('error', 'Belum ada semester aktif.');
        }

        // Cek unique voting (1 mahasiswa × 1 mata kuliah × 1 semester)
        $exists = Voting::where('mahasiswa_id', $mahasiswa->id)
            ->where('mata_kuliah_id', $request->mata_kuliah_id)
            ->where('semester_id', $semesterAktif->id)
            ->exists();

        if ($exists) {
            return redirect()->route('mahasiswa.voting')
                ->with('error', 'Anda sudah memberikan penilaian untuk mata kuliah ini di semester ini.');
        }

        // Hitung total skor
        $totalSkor = array_sum($request->nilai);
        $rataRata = round($totalSkor / count($request->nilai), 2);

        // Simpan voting
        $voting = Voting::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $request->dosen_id,
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'semester_id' => $semesterAktif->id,
            'total_skor' => $totalSkor,
            'rata_rata' => $rataRata,
            'kritik' => $request->kritik,
            'saran' => $request->saran,
        ]);

        // Simpan detail voting
        foreach ($request->nilai as $pertanyaanId => $nilai) {
            VotingDetail::create([
                'voting_id' => $voting->id,
                'pertanyaan_id' => $pertanyaanId,
                'nilai' => $nilai,
            ]);
        }

        // Update status voting mahasiswa
        $mahasiswa->update(['status_voting' => 'Sudah']);

        // Log aktivitas
        ActivityLog::logActivity(
            Auth::id(),
            'Voting',
            "Mahasiswa {$mahasiswa->nama} memberikan voting untuk dosen ID: {$request->dosen_id}"
        );

        return redirect()->route('mahasiswa.voting.hasil', $voting->id)
            ->with('success', 'Voting berhasil disimpan!');
    }

    // Halaman hasil voting
    public function hasil($id)
    {
        $voting = Voting::with(['dosen', 'mataKuliah', 'semester', 'votingDetails.pertanyaan'])
            ->findOrFail($id);

        $mahasiswa = Auth::user()->mahasiswa;

        // Cek apakah voting milik mahasiswa ini
        if ($voting->mahasiswa_id != $mahasiswa->id) {
            abort(403, 'Anda tidak memiliki akses ke voting ini.');
        }

        // Hitung kategori
        $kategori = $this->getKategori($voting->rata_rata);

        // Siapkan data untuk chart
        $labels = $voting->votingDetails->map(function ($detail) {
            return $detail->pertanyaan->kategori;
        })->toArray();

        $values = $voting->votingDetails->map(function ($detail) {
            return $detail->nilai;
        })->toArray();

        return view('mahasiswa.voting.hasil', compact('voting', 'kategori', 'labels', 'values'));
    }

    private function getKategori($rataRata)
    {
        if ($rataRata >= 4.50) return ['label' => 'Sangat Memuaskan', 'class' => 'bg-emerald-500', 'color' => '#10b981'];
        if ($rataRata >= 4.00) return ['label' => 'Memuaskan', 'class' => 'bg-blue-500', 'color' => '#3b82f6'];
        if ($rataRata >= 3.00) return ['label' => 'Puas', 'class' => 'bg-yellow-500', 'color' => '#f59e0b'];
        if ($rataRata >= 2.00) return ['label' => 'Cukup', 'class' => 'bg-orange-500', 'color' => '#f97316'];
        return ['label' => 'Tidak Puas', 'class' => 'bg-red-500', 'color' => '#ef4444'];
    }
}
