@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('header', 'Detail Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header Profile -->
        <div class="bg-gradient-navy px-6 py-8 text-center">
            <div class="w-32 h-32 rounded-full border-4 border-gold mx-auto overflow-hidden bg-white flex items-center justify-center">
                @if($mahasiswa->foto)
                    <img src="{{ Storage::url($mahasiswa->foto) }}" alt="{{ $mahasiswa->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold text-4xl font-bold">{{ substr($mahasiswa->nama, 0, 2) }}</span>
                @endif
            </div>
            <h2 class="text-2xl font-bold text-white mt-4">{{ $mahasiswa->nama }}</h2>
            <p class="text-blue-muda">{{ $mahasiswa->nim }}</p>
            <span class="inline-block mt-2 px-4 py-1 rounded-full text-sm font-semibold
                {{ $mahasiswa->status_voting == 'Sudah' ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                {{ $mahasiswa->status_voting }}
            </span>
        </div>

        <!-- Informasi -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-400">Program Studi</p>
                    <p class="text-navy font-semibold">{{ $mahasiswa->program_studi }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Semester</p>
                    <p class="text-navy font-semibold">Semester {{ $mahasiswa->semester }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Kelas</p>
                    <p class="text-navy font-semibold">{{ $mahasiswa->kelas ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Voting</p>
                    <p class="text-navy font-semibold">{{ $mahasiswa->votings->count() }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Username</p>
                    <p class="text-navy font-semibold">{{ $mahasiswa->user->username }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Email</p>
                    <p class="text-navy font-semibold">{{ $mahasiswa->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">No. HP</p>
                    <p class="text-navy font-semibold">{{ $mahasiswa->user->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Bergabung</p>
                    <p class="text-navy font-semibold">{{ $mahasiswa->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Riwayat Voting -->
            <div class="border-t border-gray-100 pt-4">
                <h4 class="font-semibold text-navy mb-3">Riwayat Voting</h4>
                @if($mahasiswa->votings->count() > 0)
                    <div class="space-y-2">
                        @foreach($mahasiswa->votings as $voting)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-navy">{{ $voting->dosen->nama ?? 'Dosen tidak ditemukan' }}</p>
                                    <p class="text-xs text-gray-400">{{ $voting->mataKuliah->nama ?? 'Mata Kuliah tidak ditemukan' }} - {{ $voting->semester->tahun_ajaran ?? '' }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-gold font-bold">{{ number_format($voting->rata_rata, 2) }}</span>
                                    <p class="text-xs text-gray-400">{{ $voting->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400">Belum ada voting</p>
                @endif
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}"
                   class="px-6 py-2.5 bg-gold text-navy rounded-lg hover:bg-gold/90 transition font-medium">
                    Edit Mahasiswa
                </a>
                @if($mahasiswa->status_voting == 'Sudah')
                    <form action="{{ route('admin.mahasiswa.reset-voting', $mahasiswa->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition font-medium"
                                onclick="return confirm('Reset voting mahasiswa {{ $mahasiswa->nama }}?')">
                            Reset Voting
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.mahasiswa.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
