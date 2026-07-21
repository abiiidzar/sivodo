@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('header', 'Dashboard Mahasiswa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profil Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-gold-15 border-2 border-gold flex items-center justify-center mb-4 overflow-hidden">
                    @if(Auth::user()->foto)
                        <img src="{{ Storage::url(Auth::user()->foto) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <span class="text-gold text-3xl font-bold">{{ substr($mahasiswa->nama, 0, 2) }}</span>
                    @endif
                </div>
                <h3 class="text-xl font-bold text-navy">{{ $mahasiswa->nama }}</h3>
                <p class="text-gray-500 text-sm">{{ $mahasiswa->nim }}</p>
                <span class="mt-2 px-3 py-1 bg-gold-10 text-gold text-xs font-semibold rounded-full">{{ $mahasiswa->program_studi }}</span>

                <div class="w-full mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Semester</span>
                        <span class="font-semibold text-navy">Semester {{ $mahasiswa->semester }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-2">
                        <span class="text-gray-500">Kelas</span>
                        <span class="font-semibold text-navy">{{ $mahasiswa->semester.' '.$mahasiswa->kelas ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-2">
                        <span class="text-gray-500">Status Voting</span>
                        <span class="font-semibold {{ $mahasiswa->status_voting == 'Sudah' ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $sudah_voting ?? 0 }}/{{ $total_dosen ?? 0 }} {{ $mahasiswa->status_voting ?? 'Belum' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik & Informasi -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100">
                <p class="text-xs text-gray-500">Total Dosen</p>
                <p class="text-2xl font-bold text-navy">{{ $total_dosen ?? 0 }}</p>  {{-- ← pakai $total_dosen --}}
            </div>
            <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100">
                <p class="text-xs text-gray-500">Sudah Dinilai</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $sudah_voting ?? 0 }}</p>  {{-- ← pakai $sudah_voting --}}
            </div>
            <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100">
                <p class="text-xs text-gray-500">Belum Dinilai</p>
                <p class="text-2xl font-bold text-red-500">{{ $belum_voting ?? 0 }}</p>  {{-- ← pakai $belum_voting --}}
            </div>
        </div>

        <!-- Progress Voting -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-semibold text-navy">Progress Voting</h4>
                <span class="text-gold font-bold text-lg">{{ $progress ?? 0 }}%</span>  {{-- ← pakai $progress --}}
            </div>
            <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-gold rounded-full transition-all duration-700" style="width: {{ $progress ?? 0 }}%"></div>
            </div>
            <p class="text-sm text-gray-500 mt-2">{{ $sudah_voting ?? 0 }} dari {{ $total_dosen ?? 0 }} dosen telah dinilai</p>
        </div>

        <!-- Informasi Semester Aktif -->
        <div class="banner-info rounded-xl p-4">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-navy">Semester Aktif</p>
                    <p class="text-sm text-gray-600">{{ $semesterAktif->tahun_ajaran ?? 'Belum ada semester aktif' }} - {{ $semesterAktif->semester ?? '-' }}</p>  {{-- ← pakai $semesterAktif --}}
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- <a href="{{ route('mahasiswa.dosen.index') }}" class="flex items-center justify-center space-x-2 px-4 py-3 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                <span>Mulai Voting</span>
            </a>
            <a href="{{ route('mahasiswa.ranking.index') }}" class="flex items-center justify-center space-x-2 px-4 py-3 border border-navy text-navy rounded-lg hover:bg-navy hover:text-white transition text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Lihat Ranking Dosen</span>
            </a> --}}
        </div>
    </div>
</div>
@endsection
