@extends('layouts.app')

@section('title', 'Detail Penilaian Dosen')
@section('header', 'Detail Penilaian Dosen')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-navy px-6 py-6 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-full border-2 border-gold bg-white flex items-center justify-center overflow-hidden">
                    @if($dosen->foto)
                        <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-navy text-2xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                    @endif
                </div>
                <div>
                    <h2 class="text-white font-bold text-2xl">{{ $dosen->nama }}</h2>
                    <p class="text-blue-muda">{{ $dosen->nidn }} - {{ $dosen->program_studi }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-blue-muda text-sm">Rata-rata</p>
                <p class="text-white text-3xl font-bold">{{ number_format($rata_rata, 2) }}</p>
                <span class="inline-block px-3 py-0.5 rounded-full text-xs font-medium text-white {{
                    $kategori == 'Sangat Memuaskan' ? 'bg-emerald-500' :
                    ($kategori == 'Memuaskan' ? 'bg-blue-500' :
                    ($kategori == 'Puas' ? 'bg-yellow-500' :
                    ($kategori == 'Cukup' ? 'bg-orange-500' : 'bg-red-500')))
                }}">
                    {{ $kategori }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">
            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100 text-center">
                    <p class="text-xs text-gray-400">Total Voting</p>
                    <p class="text-2xl font-bold text-navy">{{ $total_voting }}</p>
                </div>
                <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100 text-center">
                    <p class="text-xs text-gray-400">Rata-rata Nilai</p>
                    <p class="text-2xl font-bold text-gold">{{ number_format($rata_rata, 2) }}</p>
                </div>
                <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100 text-center">
                    <p class="text-xs text-gray-400">Kategori</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-bold text-white {{
                        $kategori == 'Sangat Memuaskan' ? 'bg-emerald-500' :
                        ($kategori == 'Memuaskan' ? 'bg-blue-500' :
                        ($kategori == 'Puas' ? 'bg-yellow-500' :
                        ($kategori == 'Cukup' ? 'bg-orange-500' : 'bg-red-500')))
                    }}">
                        {{ $kategori }}
                    </span>
                </div>
            </div>

            <!-- Daftar Voting -->
            <div class="border-t border-gray-100 pt-4">
                <h4 class="font-semibold text-navy mb-3">Daftar Voting</h4>
                @if($dosen->votings->count() > 0)
                    <div class="space-y-2">
                        @foreach($dosen->votings as $voting)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-navy">{{ $voting->mataKuliah->nama }}</p>
                                    <p class="text-xs text-gray-400">{{ $voting->semester->tahun_ajaran }} - {{ $voting->semester->semester }}</p>
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
                <a href="{{ route('mahasiswa.hasil') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
