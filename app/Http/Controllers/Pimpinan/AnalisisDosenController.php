<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Voting;
use App\Models\VotingDetail;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisDosenController extends Controller
{
    /**
     * Halaman utama analisis dosen (READ-ONLY)
     */
    public function index(Request $request)
    {
        $query = Dosen::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nidn', 'LIKE', "%{$search}%");
        }

        // Filter Prodi
        if ($request->filled('prodi')) {
            $query->where('program_studi', $request->prodi);
        }

        // Filter hanya dosen yang memiliki voting
        if ($request->filled('has_voting')) {
            if ($request->has_voting == 'yes') {
                $query->has('votings', '>', 0);
            } elseif ($request->has_voting == 'no') {
                $query->doesntHave('votings');
            }
        }

        $dosens = $query->withCount('votings')->paginate(10);
        $dosens->appends($request->all());

        $prodiList = Dosen::select('program_studi')->distinct()->pluck('program_studi');

        // Statistik
        $totalDosen = Dosen::count();
        $totalVoting = Voting::count();
        $totalMahasiswaVoting = Voting::distinct('mahasiswa_id')->count();
        $rataRataKeseluruhan = Voting::avg('rata_rata') ?? 0;

        return view('pimpinan.analisis.index', compact(
            'dosens',
            'prodiList',
            'totalDosen',
            'totalVoting',
            'totalMahasiswaVoting',
            'rataRataKeseluruhan'
        ));
    }

    /**
     * Detail analisis per dosen (READ-ONLY)
     */
    public function show($id)
    {
        $dosen = Dosen::with(['votings.mahasiswa', 'votings.votingDetails.pertanyaan'])
            ->findOrFail($id);

        // === HITUNG RATA-RATA PER PERTANYAAN ===
        $pertanyaanList = Pertanyaan::where('status', true)->orderBy('urutan')->get();

        $rataPerPertanyaan = [];
        $totalVoting = $dosen->votings->count();

        foreach ($pertanyaanList as $pertanyaan) {
            $nilaiList = [];

            foreach ($dosen->votings as $voting) {
                $detail = $voting->votingDetails->firstWhere('pertanyaan_id', $pertanyaan->id);
                if ($detail) {
                    $nilaiList[] = $detail->nilai;
                }
            }

            $rata = count($nilaiList) > 0 ? round(array_sum($nilaiList) / count($nilaiList), 2) : 0;
            $rataPerPertanyaan[$pertanyaan->id] = [
                'pertanyaan' => $pertanyaan,
                'rata_rata' => $rata,
                'jumlah' => count($nilaiList),
                'nilai_list' => $nilaiList,
            ];
        }

        // === HITUNG KATEGORI KELEMAHAN ===
        $kelemahan = [];
        foreach ($rataPerPertanyaan as $key => $data) {
            if ($data['rata_rata'] > 0 && $data['rata_rata'] < 3.5) {
                $kelemahan[] = [
                    'pertanyaan' => $data['pertanyaan'],
                    'rata_rata' => $data['rata_rata'],
                    'kategori' => $this->getKategori($data['rata_rata']),
                ];
            }
        }

        // Urutkan dari yang terendah
        usort($kelemahan, function ($a, $b) {
            return $a['rata_rata'] <=> $b['rata_rata'];
        });

        // === HITUNG STATISTIK ===
        $rataRataKeseluruhan = $totalVoting > 0 ? round($dosen->votings->avg('rata_rata'), 2) : 0;

        // === REKAP DISTRIBUSI NILAI ===
        $distribusiNilai = [
            1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0
        ];

        foreach ($dosen->votings as $voting) {
            foreach ($voting->votingDetails as $detail) {
                if (isset($distribusiNilai[$detail->nilai])) {
                    $distribusiNilai[$detail->nilai]++;
                }
            }
        }

        // === REKAP PER MAHASISWA ===
        $rekapMahasiswa = [];
        foreach ($dosen->votings as $voting) {
            $mahasiswa = $voting->mahasiswa;
            $rekapMahasiswa[] = (object) [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->nim,
                'total_skor' => $voting->total_skor,
                'rata_rata' => $voting->rata_rata,
                'kritik' => $voting->kritik,
                'saran' => $voting->saran,
                'created_at' => $voting->created_at,
            ];
        }

        // Urutkan dari yang terendah
        usort($rekapMahasiswa, function ($a, $b) {
            return $a->rata_rata <=> $b->rata_rata;
        });

        return view('pimpinan.analisis.show', compact(
            'dosen',
            'rataPerPertanyaan',
            'kelemahan',
            'totalVoting',
            'rataRataKeseluruhan',
            'distribusiNilai',
            'rekapMahasiswa',
            'pertanyaanList'
        ));
    }


    /**
     * Export analisis ke PDF
     */
    public function exportPdf($id)
    {
        $dosen = Dosen::with(['votings.mahasiswa', 'votings.votingDetails.pertanyaan'])
            ->findOrFail($id);

        $pertanyaanList = Pertanyaan::where('status', true)->orderBy('urutan')->get();

        $rataPerPertanyaan = [];
        $totalVoting = $dosen->votings->count();

        foreach ($pertanyaanList as $pertanyaan) {
            $nilaiList = [];
            foreach ($dosen->votings as $voting) {
                $detail = $voting->votingDetails->firstWhere('pertanyaan_id', $pertanyaan->id);
                if ($detail) {
                    $nilaiList[] = $detail->nilai;
                }
            }
            $rata = count($nilaiList) > 0 ? round(array_sum($nilaiList) / count($nilaiList), 2) : 0;
            $rataPerPertanyaan[$pertanyaan->id] = [
                'pertanyaan' => $pertanyaan,
                'rata_rata' => $rata,
                'jumlah' => count($nilaiList),
            ];
        }

        $kelemahan = [];
        foreach ($rataPerPertanyaan as $key => $data) {
            if ($data['rata_rata'] > 0 && $data['rata_rata'] < 3.5) {
                $kelemahan[] = [
                    'pertanyaan' => $data['pertanyaan'],
                    'rata_rata' => $data['rata_rata'],
                    'kategori' => $this->getKategori($data['rata_rata']),
                ];
            }
        }
        usort($kelemahan, function ($a, $b) {
            return $a['rata_rata'] <=> $b['rata_rata'];
        });

        $rataRataKeseluruhan = $totalVoting > 0 ? round($dosen->votings->avg('rata_rata'), 2) : 0;

        $rekapMahasiswa = [];
        foreach ($dosen->votings as $voting) {
            $mahasiswa = $voting->mahasiswa;
            $rekapMahasiswa[] = (object) [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->nim,
                'total_skor' => $voting->total_skor,
                'rata_rata' => $voting->rata_rata,
                'kritik' => $voting->kritik,
                'saran' => $voting->saran,
                'created_at' => $voting->created_at,
            ];
        }
        usort($rekapMahasiswa, function ($a, $b) {
            return $a->rata_rata <=> $b->rata_rata;
        });

        $distribusiNilai = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        foreach ($dosen->votings as $voting) {
            foreach ($voting->votingDetails as $detail) {
                if (isset($distribusiNilai[$detail->nilai])) {
                    $distribusiNilai[$detail->nilai]++;
                }
            }
        }

        $data = compact(
            'dosen',
            'rataPerPertanyaan',
            'kelemahan',
            'totalVoting',
            'rataRataKeseluruhan',
            'distribusiNilai',
            'rekapMahasiswa',
            'pertanyaanList'
        );

        $pdf = Pdf::loadView('pimpinan.analisis.export-pdf', $data);
        $pdf->setPaper('a4', 'portrait'); // A4 Portrait

        return $pdf->download('Analisis_Dosen_' . $dosen->nama . '_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export analisis ke Excel
     */
    public function exportExcel($id)
    {
        $dosen = Dosen::with(['votings.mahasiswa', 'votings.votingDetails.pertanyaan'])
            ->findOrFail($id);

        $pertanyaanList = Pertanyaan::where('status', true)->orderBy('urutan')->get();

        $rataPerPertanyaan = [];
        foreach ($pertanyaanList as $pertanyaan) {
            $nilaiList = [];
            foreach ($dosen->votings as $voting) {
                $detail = $voting->votingDetails->firstWhere('pertanyaan_id', $pertanyaan->id);
                if ($detail) {
                    $nilaiList[] = $detail->nilai;
                }
            }
            $rata = count($nilaiList) > 0 ? round(array_sum($nilaiList) / count($nilaiList), 2) : 0;
            $rataPerPertanyaan[$pertanyaan->id] = [
                'pertanyaan' => $pertanyaan,
                'rata_rata' => $rata,
                'jumlah' => count($nilaiList),
            ];
        }

        $rekapMahasiswa = [];
        foreach ($dosen->votings as $voting) {
            $mahasiswa = $voting->mahasiswa;
            $rekapMahasiswa[] = [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->nim,
                'total_skor' => $voting->total_skor,
                'rata_rata' => $voting->rata_rata,
                'kritik' => $voting->kritik,
                'saran' => $voting->saran,
                'tanggal' => $voting->created_at->format('d M Y H:i'),
            ];
        }
        usort($rekapMahasiswa, function ($a, $b) {
            return $a['rata_rata'] <=> $b['rata_rata'];
        });

        $rataRataKeseluruhan = $dosen->votings->count() > 0 ? round($dosen->votings->avg('rata_rata'), 2) : 0;

        $data = [
            'dosen' => $dosen,
            'rataPerPertanyaan' => $rataPerPertanyaan,
            'rekapMahasiswa' => $rekapMahasiswa,
            'rataRataKeseluruhan' => $rataRataKeseluruhan,
            'totalVoting' => $dosen->votings->count(),
            'pertanyaanList' => $pertanyaanList,
        ];

        return Excel::download(new AnalisisDosenExport($data), 'Analisis_Dosen_' . $dosen->nama . '_' . date('Y-m-d') . '.xlsx');
    }


    /**
     * Get kategori berdasarkan rata-rata
     */
    private function getKategori($rata)
    {
        if ($rata >= 3.50) return ['label' => 'Sangat Baik', 'class' => 'bg-emerald-500'];
        if ($rata >= 3.00) return ['label' => 'Baik', 'class' => 'bg-blue-500'];
        if ($rata >= 2.50) return ['label' => 'Cukup', 'class' => 'bg-yellow-500'];
        if ($rata >= 2.00) return ['label' => 'Kurang', 'class' => 'bg-orange-500'];
        return ['label' => 'Sangat Kurang', 'class' => 'bg-red-500'];
    }
}
