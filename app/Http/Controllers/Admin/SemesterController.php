<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        $query = Semester::query();

        // Search berdasarkan Tahun Ajaran
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('tahun_ajaran', 'LIKE', "%{$search}%");
        }

        // Filter berdasarkan Semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $semesters = $query->latest()->paginate(10);
        $semesters->appends($request->all());

        return view('admin.semester.index', compact('semesters'));
    }

    public function create()
    {
        return view('admin.semester.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        // Jika status Aktif, set semua semester lain menjadi Tidak Aktif
        if ($request->status == 'Aktif') {
            Semester::where('status', 'Aktif')->update(['status' => 'Tidak Aktif']);
        }

        $semester = Semester::create($request->all());

        ActivityLog::logActivity(
            auth()->id(),
            'Tambah Semester',
            "Menambahkan semester {$semester->tahun_ajaran} - {$semester->semester} (Status: {$semester->status})"
        );

        return redirect()->route('admin.semester.index')
            ->with('success', 'Semester berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $semester = Semester::findOrFail($id);
        return view('admin.semester.edit', compact('semester'));
    }

    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);

        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        // Jika status Aktif, set semua semester lain menjadi Tidak Aktif
        if ($request->status == 'Aktif') {
            Semester::where('status', 'Aktif')->where('id', '!=', $id)->update(['status' => 'Tidak Aktif']);
        }

        $semester->update($request->all());

        ActivityLog::logActivity(
            auth()->id(),
            'Edit Semester',
            "Mengedit semester {$semester->tahun_ajaran} - {$semester->semester}"
        );

        return redirect()->route('admin.semester.index')
            ->with('success', 'Semester berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        $nama = $semester->tahun_ajaran . ' - ' . $semester->semester;
        $semester->delete();

        ActivityLog::logActivity(
            auth()->id(),
            'Hapus Semester',
            "Menghapus semester {$nama}"
        );

        return redirect()->route('admin.semester.index')
            ->with('success', 'Semester berhasil dihapus!');
    }

    public function setAktif($id)
    {
        // Set semua semester menjadi Tidak Aktif
        Semester::where('status', 'Aktif')->update(['status' => 'Tidak Aktif']);

        // Aktifkan semester yang dipilih
        $semester = Semester::findOrFail($id);
        $semester->update(['status' => 'Aktif']);

        ActivityLog::logActivity(
            auth()->id(),
            'Set Semester Aktif',
            "Mengaktifkan semester {$semester->tahun_ajaran} - {$semester->semester}"
        );

        return redirect()->back()
            ->with('success', "Semester {$semester->tahun_ajaran} - {$semester->semester} berhasil diaktifkan!");
    }
}
