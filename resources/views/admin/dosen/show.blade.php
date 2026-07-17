@extends('layouts.app')

@section('title', 'Detail Dosen')
@section('header', 'Detail Dosen')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header Profile -->
        <div class="bg-gradient-navy px-6 py-8 text-center">
            <div class="w-32 h-32 rounded-full border-4 border-gold mx-auto overflow-hidden bg-white flex items-center justify-center">
                @if($dosen->foto)
                    <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold text-4xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                @endif
            </div>
            <h2 class="text-2xl font-bold text-white mt-4">{{ $dosen->nama }}</h2>
            <p class="text-blue-muda">{{ $dosen->nidn }}</p>
            <span class="inline-block mt-2 px-4 py-1 bg-gold-20 text-gold text-sm font-semibold rounded-full">
                {{ $dosen->status_dosen }}
            </span>
        </div>

        <!-- Informasi -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-400">Program Studi</p>
                    <p class="text-navy font-semibold">{{ $dosen->program_studi }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Status Dosen</p>
                    <p class="text-navy font-semibold">{{ $dosen->status_dosen }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Mata Kuliah</p>
                    <p class="text-navy font-semibold">{{ $dosen->mataKuliahs->count() }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Voting</p>
                    <p class="text-navy font-semibold">{{ $dosen->votings->count() }}</p>
                </div>
            </div>

            <!-- Mata Kuliah yang Diajar -->
            <div class="border-t border-gray-100 pt-4">
                <h4 class="font-semibold text-navy mb-3">Mata Kuliah yang Diajar</h4>
                @if($dosen->mataKuliahs->count() > 0)
                    <div class="space-y-2">
                        @foreach($dosen->mataKuliahs as $mk)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-navy">{{ $mk->nama }}</p>
                                    <p class="text-xs text-gray-400">{{ $mk->kode }} - {{ $mk->semester }}</p>
                                </div>
                                <span class="text-xs text-gray-400">{{ $mk->kelas ?? '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400">Belum ada mata kuliah yang diajar</p>
                @endif
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.dosen.edit', $dosen->id) }}"
                   class="px-6 py-2.5 bg-gold text-navy rounded-lg hover:bg-gold/90 transition font-medium">
                    Edit Dosen
                </a>
                <a href="{{ route('admin.dosen.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
