<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = MataKuliah::with('dosen');

        // Search berdasarkan Kode atau Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan Dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Filter berdasarkan Semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter berdasarkan Kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $matakuliahs = $query->latest()->paginate(10);
        $matakuliahs->appends($request->all());

        // Ambil daftar dosen untuk filter
        $dosens = Dosen::orderBy('nama')->get();

        // Ambil daftar kelas unik untuk filter
        $kelasList = MataKuliah::select('kelas')->whereNotNull('kelas')->distinct()->pluck('kelas');

        return view('admin.matakuliah.index', compact('matakuliahs', 'dosens', 'kelasList'));
    }

    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get();
        return view('admin.matakuliah.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_kuliahs',
            'nama' => 'required|string|max:100',
            'dosen_id' => 'required|exists:dosens,id',
            'kelas' => 'nullable|string|max:10',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $matakuliah = MataKuliah::create($request->all());

        ActivityLog::logActivity(
            auth()->id(),
            'Tambah Mata Kuliah',
            "Menambahkan mata kuliah {$matakuliah->nama} (Kode: {$matakuliah->kode})"
        );

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function show($id)
    {
        $matakuliah = MataKuliah::with('dosen', 'votings.mahasiswa', 'votings.semester')
            ->findOrFail($id);
        return view('admin.matakuliah.show', compact('matakuliah'));
    }

    public function edit($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $dosens = Dosen::orderBy('nama')->get();
        return view('admin.matakuliah.edit', compact('matakuliah', 'dosens'));
    }

    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_kuliahs,kode,' . $id,
            'nama' => 'required|string|max:100',
            'dosen_id' => 'required|exists:dosens,id',
            'kelas' => 'nullable|string|max:10',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $matakuliah->update($request->all());

        ActivityLog::logActivity(
            auth()->id(),
            'Edit Mata Kuliah',
            "Mengedit mata kuliah {$matakuliah->nama} (Kode: {$matakuliah->kode})"
        );

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $nama = $matakuliah->nama;
        $matakuliah->delete();

        ActivityLog::logActivity(
            auth()->id(),
            'Hapus Mata Kuliah',
            "Menghapus mata kuliah {$nama}"
        );

        return redirect()->route('admin.matakuliah.index')
            ->with('success', 'Mata Kuliah berhasil dihapus!');
    }

    public function import(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur import dalam pengembangan');
    }
}
