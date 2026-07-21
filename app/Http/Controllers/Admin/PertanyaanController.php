<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pertanyaan::query();

        // Search berdasarkan Pertanyaan atau Kategori
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pertanyaan', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pertanyaans = $query->orderBy('urutan')->paginate(10);
        $pertanyaans->appends($request->all());

        // Ambil daftar kategori unik untuk filter
        $kategoriList = Pertanyaan::select('kategori')->distinct()->pluck('kategori');

        return view('admin.pertanyaan.index', compact('pertanyaans', 'kategoriList'));
    }

    public function create()
    {
        $maxUrutan = Pertanyaan::max('urutan') ?? 0;
        return view('admin.pertanyaan.create', compact('maxUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:50',
            'pertanyaan' => 'required|string',
            'urutan' => 'required|integer|unique:pertanyaans',
            'status' => 'required|boolean',
        ]);

        $pertanyaan = Pertanyaan::create($request->all());

        ActivityLog::logActivity(
            auth()->id(),
            'Tambah Pertanyaan',
            "Menambahkan pertanyaan: {$pertanyaan->pertanyaan}"
        );

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        return view('admin.pertanyaan.edit', compact('pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'kategori' => 'required|string|max:50',
            'pertanyaan' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $pertanyaan->update($request->all());

        ActivityLog::logActivity(
            auth()->id(),
            'Edit Pertanyaan',
            "Mengedit pertanyaan: {$pertanyaan->pertanyaan}"
        );

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $teks = $pertanyaan->pertanyaan;
        $pertanyaan->delete();

        ActivityLog::logActivity(
            auth()->id(),
            'Hapus Pertanyaan',
            "Menghapus pertanyaan: {$teks}"
        );

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->status = !$pertanyaan->status;
        $pertanyaan->save();

        ActivityLog::logActivity(
            auth()->id(),
            'Toggle Status Pertanyaan',
            "Mengubah status pertanyaan menjadi " . ($pertanyaan->status ? 'Aktif' : 'Tidak Aktif')
        );

        return redirect()->back()
            ->with('success', 'Status pertanyaan berhasil diubah!');
    }

    public function reorder(Request $request)
    {
        $orders = $request->orders;
        foreach ($orders as $order) {
            Pertanyaan::where('id', $order['id'])->update(['urutan' => $order['urutan']]);
        }

        ActivityLog::logActivity(
            auth()->id(),
            'Reorder Pertanyaan',
            "Mengubah urutan pertanyaan"
        );

        return response()->json(['success' => true]);
    }
}
