@extends('layouts.app')

@section('title', 'Detail Mata Kuliah')
@section('header', 'Detail Mata Kuliah')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-navy px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3">
                        <span class="px-4 py-1.5 bg-gold-20 text-gold text-sm font-bold rounded-lg">
                            {{ $matakuliah->kode }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $matakuliah->semester == 'Ganjil' ? 'bg-blue-500 text-white' : 'bg-orange-500 text-white' }}">
                            {{ $matakuliah->semester }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mt-3">{{ $matakuliah->nama }}</h2>
                    <p class="text-blue-muda text-sm">Kelas {{ $matakuliah->kelas ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-muda text-sm">Total Voting</p>
                    <p class="text-white text-3xl font-bold">{{ $matakuliah->votings->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-400">Dosen Pengampu</p>
                    <div class="mt-1">
                        <p class="text-navy font-semibold">
                            {{ $matakuliah->dosen->nama ?? 'Tidak ada' }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $matakuliah->dosen->nidn ?? '' }}
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Kelas</p>
                    <p class="text-navy font-semibold">{{ $matakuliah->kelas ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Semester</p>
                    <p class="text-navy font-semibold">{{ $matakuliah->semester }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Dibuat</p>
                    <p class="text-navy font-semibold">{{ $matakuliah->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Daftar Voting -->
            <div class="border-t border-gray-100 pt-4">
                <h4 class="font-semibold text-navy mb-3">Daftar Voting</h4>
                @if($matakuliah->votings->count() > 0)
                    <div class="space-y-2">
                        @foreach($matakuliah->votings as $voting)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-navy">{{ $voting->mahasiswa->nama ?? 'Mahasiswa tidak ditemukan' }}</p>
                                    <p class="text-xs text-gray-400">{{ $voting->mahasiswa->nim ?? '' }} - {{ $voting->semester->tahun_ajaran ?? '' }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-gold font-bold">{{ number_format($voting->rata_rata, 2) }}</span>
                                    <p class="text-xs text-gray-400">{{ $voting->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400">Belum ada voting untuk mata kuliah ini</p>
                @endif
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.matakuliah.edit', $matakuliah->id) }}"
                   class="px-6 py-2.5 bg-gold text-navy rounded-lg hover:bg-gold/90 transition font-medium">
                    Edit Mata Kuliah
                </a>
                <a href="{{ route('admin.matakuliah.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
