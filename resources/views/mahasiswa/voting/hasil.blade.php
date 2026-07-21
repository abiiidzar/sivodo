@extends('layouts.app')

@section('title', 'Hasil Voting')
@section('header', 'Hasil Voting')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Alert Success -->
    <div class="banner-success rounded-lg p-4 flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-emerald-700 font-medium">Voting berhasil disimpan!</span>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                @if($voting->dosen->foto)
                    <img src="{{ Storage::url($voting->dosen->foto) }}" alt="{{ $voting->dosen->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold text-xl font-bold">{{ substr($voting->dosen->nama, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-bold text-navy">{{ $voting->dosen->nama }}</h3>
                <p class="text-sm text-gray-500">NIDN: {{ $voting->dosen->nidn }} | {{ $voting->dosen->program_studi }}</p>
                <p class="text-sm text-gray-500">{{ $voting->mataKuliah->nama }} - {{ $voting->semester->tahun_ajaran }} {{ $voting->semester->semester }}</p>
            </div>
        </div>
    </div>

    <!-- Hasil Skor -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-500">Total Skor</p>
            <p class="text-3xl font-bold text-navy">{{ $voting->total_skor }} <span class="text-lg text-gray-400">/ 45</span></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-500">Rata-rata</p>
            <p class="text-3xl font-bold text-gold">{{ number_format($voting->rata_rata, 2) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-500">Kategori</p>
            <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold text-white {{ $kategori['class'] }}">
                {{ $kategori['label'] }}
            </span>
        </div>
    </div>

    <!-- Detail Penilaian per Pertanyaan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-4">Detail Penilaian</h4>
        <div class="space-y-4">
            @foreach($voting->votingDetails as $detail)
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-navy">{{ $detail->pertanyaan->kategori }}</p>
                        <p class="text-xs text-gray-500">{{ $detail->pertanyaan->pertanyaan }}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $detail->nilai ? 'text-navy' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                        <span class="ml-2 text-sm font-semibold text-navy">{{ $detail->nilai }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Kritik & Saran -->
    @if($voting->kritik || $voting->saran)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            @if($voting->kritik)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="font-semibold text-navy mb-2">Kritik</h4>
                    <p class="text-sm text-gray-600">{{ $voting->kritik }}</p>
                </div>
            @endif
            @if($voting->saran)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="font-semibold text-navy mb-2">Saran</h4>
                    <p class="text-sm text-gray-600">{{ $voting->saran }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Tombol -->
    <div class="flex items-center gap-3 mt-6">
        <a href="{{ route('mahasiswa.voting') }}"
           class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium">
            Kembali ke Daftar Dosen
        </a>
        <a href="{{ route('mahasiswa.ranking') }}"
           class="px-6 py-2.5 border border-navy text-navy rounded-lg hover:bg-navy hover:text-white transition font-medium">
            Lihat Ranking Dosen
        </a>
    </div>
</div>
@endsection
