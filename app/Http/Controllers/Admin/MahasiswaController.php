<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with('user');

        // Search berdasarkan NIM atau Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan Program Studi
        if ($request->filled('prodi')) {
            $query->where('program_studi', $request->prodi);
        }

        // Filter berdasarkan Status Voting
        if ($request->filled('status_voting')) {
            $query->where('status_voting', $request->status_voting);
        }

        // Filter berdasarkan Semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $mahasiswas = $query->latest()->paginate(10);
        $mahasiswas->appends($request->all());

        // Ambil daftar prodi unik untuk filter
        $prodiList = Mahasiswa::select('program_studi')->distinct()->pluck('program_studi');

        return view('admin.mahasiswa.index', compact('mahasiswas', 'prodiList'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswas',
            'program_studi' => 'required|string|max:50',
            'semester' => 'required|integer|min:1|max:14',
            'kelas' => 'nullable|string|max:10',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Create User
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'no_hp' => $request->no_hp,
        ]);

        // Create Mahasiswa
        $data = $request->except(['email', 'username', 'password', 'no_hp']);
        $data['user_id'] = $user->id;
        $data['status_voting'] = 'Belum';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mahasiswa-photos', 'public');
        }

        $mahasiswa = Mahasiswa::create($data);

        ActivityLog::logActivity(
            auth()->id(),
            'Tambah Mahasiswa',
            "Menambahkan mahasiswa {$mahasiswa->nama} (NIM: {$mahasiswa->nim})"
        );

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::with('user', 'votings.dosen', 'votings.mataKuliah', 'votings.semester')
            ->findOrFail($id);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $id,
            'program_studi' => 'required|string|max:50',
            'semester' => 'required|integer|min:1|max:14',
            'kelas' => 'nullable|string|max:10',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'username' => 'required|string|max:50|unique:users,username,' . $mahasiswa->user_id,
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update User
        $mahasiswa->user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        // Update Mahasiswa
        $data = $request->except(['email', 'username', 'no_hp']);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('mahasiswa-photos', 'public');
        }

        $mahasiswa->update($data);

        ActivityLog::logActivity(
            auth()->id(),
            'Edit Mahasiswa',
            "Mengedit mahasiswa {$mahasiswa->nama} (NIM: {$mahasiswa->nim})"
        );

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);

        if ($mahasiswa->foto) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }

        $nama = $mahasiswa->nama;
        $userId = $mahasiswa->user_id;
        $mahasiswa->delete();
        User::find($userId)->delete();

        ActivityLog::logActivity(
            auth()->id(),
            'Hapus Mahasiswa',
            "Menghapus mahasiswa {$nama}"
        );

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus!');
    }

    public function resetVoting($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $count = $mahasiswa->votings()->count();
        $mahasiswa->votings()->delete();
        $mahasiswa->update(['status_voting' => 'Belum']);

        ActivityLog::logActivity(
            auth()->id(),
            'Reset Voting',
            "Meriset voting mahasiswa {$mahasiswa->nama} (NIM: {$mahasiswa->nim}) - {$count} voting dihapus"
        );

        return redirect()->back()
            ->with('success', "Voting mahasiswa berhasil direset! ({$count} voting dihapus)");
    }

    public function import(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur import dalam pengembangan');
    }

    public function export()
    {
        return redirect()->back()->with('info', 'Fitur export dalam pengembangan');
    }
}
