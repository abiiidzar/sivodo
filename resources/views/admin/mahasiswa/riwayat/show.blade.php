@extends('layouts.app')

@section('title', 'Detail Riwayat')
@section('header', 'Detail Riwayat Voting')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-navy px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full border-2 border-gold bg-white flex items-center justify-center overflow-hidden">
                        @if($voting->dosen->foto)
                            <img src="{{ Storage::url($voting->dosen->foto) }}" alt="{{ $voting->dosen->nama }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-navy text-xl font-bold">{{ substr($voting->dosen->nama, 0, 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-white font-bold">{{ $voting->dosen->nama }}</h2>
                        <p class="text-blue-muda text-sm">{{ $voting->mataKuliah->nama }}</p>
                        <p class="text-blue-muda/70 text-xs">{{ $voting->semester->tahun_ajaran }} - {{ $voting->semester->semester }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-blue-muda text-sm">Nilai</p>
                    <p class="text-white text-2xl font-bold">{{ number_format($voting->rata_rata, 2) }}</p>
                    <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium text-white {{ $kategori['class'] }}">
                        {{ $kategori['label'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Detail -->
        <div class="p-6 space-y-6">
            <!-- Rincian Nilai -->
            <div>
                <h4 class="font-semibold text-navy mb-3">Rincian Penilaian</h4>
                <div class="space-y-2">
                    @foreach($voting->votingDetails as $detail)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-navy">{{ $detail->pertanyaan->pertanyaan }}</p>
                            <span class="text-xs text-gray-400">{{ $detail->pertanyaan->kategori }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $detail->nilai ? 'rating-star-' . $i : 'rating-star-default' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-navy w-6 text-center">{{ $detail->nilai }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Kritik & Saran -->
            @if($voting->kritik || $voting->saran)
            <div class="border-t border-gray-100 pt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($voting->kritik)
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Kritik</p>
                        <p class="text-navy mt-1 p-3 bg-gray-50 rounded-lg">{{ $voting->kritik }}</p>
                    </div>
                    @endif
                    @if($voting->saran)
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Saran</p>
                        <p class="text-navy mt-1 p-3 bg-gray-50 rounded-lg">{{ $voting->saran }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Info -->
            <div class="border-t border-gray-100 pt-4 flex flex-wrap items-center justify-between gap-2 text-sm text-gray-500">
                <span>Dibuat: {{ $voting->created_at->format('d M Y H:i:s') }}</span>
                <span>Total Skor: {{ $voting->total_skor }} / {{ $voting->votingDetails->count() * 5 }}</span>
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('mahasiswa.riwayat') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
