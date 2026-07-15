@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')

@section('header', 'Dashboard Pimpinan')

@section('content')
<!-- Statistik Utama -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Voting</p>
                <p class="text-3xl font-bold text-navy mt-1">{{ $total_voting }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Rata-rata Kepuasan</p>
                <p class="text-3xl font-bold text-gold mt-1">{{ number_format($rata_rata_kepuasan, 2) }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-gold-10 flex items-center justify-center">
                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Mahasiswa Voting</p>
                <p class="text-3xl font-bold text-navy mt-1">{{ $total_mahasiswa_voting }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Dosen</p>
                <p class="text-3xl font-bold text-navy mt-1">{{ $total_dosen }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Dosen Terbaik & Perlu Pembinaan -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    @if($dosen_terbaik)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-semibold text-navy">🏆 Dosen Terbaik</h4>
            <span class="rank-1 px-3 py-1 rounded-full text-xs font-bold">#1</span>
        </div>
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-gold-15 border-2 border-gold flex items-center justify-center overflow-hidden">
                @if($dosen_terbaik->foto)
                    <img src="{{ Storage::url($dosen_terbaik->foto) }}" alt="{{ $dosen_terbaik->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold text-xl font-bold">{{ substr($dosen_terbaik->nama, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <p class="font-bold text-navy text-lg">{{ $dosen_terbaik->nama }}</p>
                <p class="text-sm text-gray-500">{{ $dosen_terbaik->program_studi }}</p>
                <div class="flex items-center space-x-2 mt-1">
                    <span class="text-gold font-bold text-xl">{{ number_format($dosen_terbaik->getRataRata(), 2) }}</span>
                    <span class="text-xs px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full">{{ $dosen_terbaik->getKategori() }}</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">Total Voting: {{ $dosen_terbaik->getTotalVoting() }} mahasiswa</p>
        </div>
    </div>
    @endif

    @if($dosen_perlu_pembinaan)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-semibold text-navy">📋 Perlu Pembinaan</h4>
            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Perhatian</span>
        </div>
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-red-50 border-2 border-red-300 flex items-center justify-center overflow-hidden">
                @if($dosen_perlu_pembinaan->foto)
                    <img src="{{ Storage::url($dosen_perlu_pembinaan->foto) }}" alt="{{ $dosen_perlu_pembinaan->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-red-500 text-xl font-bold">{{ substr($dosen_perlu_pembinaan->nama, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <p class="font-bold text-navy text-lg">{{ $dosen_perlu_pembinaan->nama }}</p>
                <p class="text-sm text-gray-500">{{ $dosen_perlu_pembinaan->program_studi }}</p>
                <div class="flex items-center space-x-2 mt-1">
                    <span class="text-red-500 font-bold text-xl">{{ number_format($dosen_perlu_pembinaan->getRataRata(), 2) }}</span>
                    <span class="text-xs px-2 py-0.5 bg-red-50 text-red-600 rounded-full">{{ $dosen_perlu_pembinaan->getKategori() }}</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">Total Voting: {{ $dosen_perlu_pembinaan->getTotalVoting() }} mahasiswa</p>
        </div>
    </div>
    @endif
</div>

<!-- Grafik & Ranking Preview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-4">📊 Grafik Kepuasan Mahasiswa</h4>
        <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
            <p class="text-gray-400">Grafik akan tampil di sini (Chart.js)</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-4">🏅 Top 3 Dosen</h4>
        <div class="space-y-4">
            @foreach($top_dosen as $index => $dosen)
            <div class="flex items-center space-x-3 p-3 rounded-lg {{ $index == 0 ? 'bg-gold-10' : ($index == 1 ? 'bg-gray-50' : 'bg-orange-50') }}">
                <span class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm
                    {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : 'rank-3') }}">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-navy">{{ $dosen->nama }}</p>
                    <p class="text-xs text-gray-500">{{ $dosen->program_studi }}</p>
                </div>
                <span class="text-gold font-bold">{{ number_format($dosen->getRataRata(), 2) }}</span>
            </div>
            @endforeach
        </div>
        <a href="#" class="block text-center mt-4 text-sm text-gold hover:underline">Lihat semua ranking →</a>
    </div>
</div>
@endsection
