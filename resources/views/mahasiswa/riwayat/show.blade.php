@extends('layouts.app')

@section('title', 'Detail Riwayat Voting')
@section('header', 'Detail Riwayat Voting')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Alert -->
    @if(session('success'))
        <div class="banner-success rounded-lg p-4 flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-emerald-700">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Informasi Dosen & Mata Kuliah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                @if($voting->dosen->foto)
                    <img src="{{ Storage::url($voting->dosen->foto) }}" alt="{{ $voting->dosen->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold text-2xl font-bold">{{ substr($voting->dosen->nama, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-bold text-navy">{{ $voting->dosen->nama }}</h3>
                <p class="text-sm text-gray-500">NIDN: {{ $voting->dosen->nidn }} | {{ $voting->dosen->program_studi }}</p>
                <div class="flex flex-wrap gap-2 mt-1">
                    <span class="text-xs bg-gold-10 text-gold px-2 py-0.5 rounded">{{ $voting->mataKuliah->nama }}</span>
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $voting->mataKuliah->kode }}</span>
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $voting->semester->tahun_ajaran }} - {{ $voting->semester->semester }}</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between text-sm text-gray-500">
            <span>Tanggal Voting: <strong class="text-navy">{{ $voting->created_at->format('d M Y H:i:s') }}</strong></span>
            <span>Status: <strong class="text-emerald-600">Sudah Voting</strong></span>
        </div>
    </div>

    <!-- Hasil Skor -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-500">Total Skor</p>
            <p class="text-2xl font-bold text-navy">{{ $voting->total_skor }} / {{ $voting->votingDetails->count() * 5 }}</p>
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
                <div class="flex flex-col md:flex-row md:items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-navy">{{ $detail->pertanyaan->kategori }}</p>
                        <p class="text-xs text-gray-500">{{ $detail->pertanyaan->pertanyaan }}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $i <= $detail->nilai ? 'text-navy' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
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
                    <h4 class="font-semibold text-navy mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Kritik
                    </h4>
                    <p class="text-sm text-gray-600">{{ $voting->kritik }}</p>
                </div>
            @endif
            @if($voting->saran)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="font-semibold text-navy mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Saran
                    </h4>
                    <p class="text-sm text-gray-600">{{ $voting->saran }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Tombol -->
    <div class="flex flex-wrap items-center gap-3 mt-6">
        <a href="{{ route('mahasiswa.riwayat') }}"
           class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Riwayat
        </a>
        {{-- <a href="{{ route('mahasiswa.ranking') }}"
           class="px-6 py-2.5 border border-navy text-navy rounded-lg hover:bg-navy hover:text-white transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Lihat Ranking Dosen
        </a>
        <a href="{{ route('mahasiswa.hasil.show', $voting->dosen_id) }}"
           class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Lihat Hasil Dosen
        </a> --}}
    </div>

    <!-- Info -->
    <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
        <div class="flex items-center gap-2 text-xs text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Data ini adalah riwayat voting Anda. Voting tidak dapat diubah setelah dikirim.</span>
        </div>
    </div>
</div>
@endsection
