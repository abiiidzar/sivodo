<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::query();

        // Search berdasarkan NIDN atau Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nidn', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan Status Dosen
        if ($request->filled('status')) {
            $query->where('status_dosen', $request->status);
        }

        $dosens = $query->latest()->paginate(10);

        // Pertahankan parameter saat pagination
        $dosens->appends($request->all());

        return view('admin.dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|unique:dosens',
            'nama' => 'required',
            'program_studi' => 'required',
            'status_dosen' => 'required|in:PNS,Yayasan,Luar Biasa',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('dosen-photos', 'public');
        }

        $dosen = Dosen::create($data);

        ActivityLog::logActivity(
            auth()->id(),
            'Tambah Dosen',
            "Menambahkan dosen {$dosen->nama} (NIDN: {$dosen->nidn})"
        );

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function show($id)
    {
        $dosen = Dosen::with('mataKuliahs')->findOrFail($id);
        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nidn' => 'required|unique:dosens,nidn,' . $id,
            'nama' => 'required',
            'program_studi' => 'required',
            'status_dosen' => 'required|in:PNS,Yayasan,Luar Biasa',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($dosen->foto) {
                Storage::disk('public')->delete($dosen->foto);
            }
            $data['foto'] = $request->file('foto')->store('dosen-photos', 'public');
        }

        $dosen->update($data);

        ActivityLog::logActivity(
            auth()->id(),
            'Edit Dosen',
            "Mengedit dosen {$dosen->nama} (NIDN: {$dosen->nidn})"
        );

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        if ($dosen->foto) {
            Storage::disk('public')->delete($dosen->foto);
        }

        $nama = $dosen->nama;
        $dosen->delete();

        ActivityLog::logActivity(
            auth()->id(),
            'Hapus Dosen',
            "Menghapus dosen {$nama}"
        );

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil dihapus!');
    }

    public function import(Request $request)
    {
        // TODO: Implement import Excel
        return redirect()->back()->with('info', 'Fitur import dalam pengembangan');
    }

    public function export()
    {
        // TODO: Implement export Excel
        return redirect()->back()->with('info', 'Fitur export dalam pengembangan');
    }
}
