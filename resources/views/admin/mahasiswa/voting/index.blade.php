@extends('layouts.app')

@section('title', 'Daftar Dosen - Voting')
@section('header', 'Daftar Dosen')

@section('content')
<div class="space-y-6">
    <!-- Alert -->
    @if(session('success'))
        <div class="banner-success rounded-lg p-4 flex items-center justify-between">
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

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Info Mahasiswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama</p>
                <p class="font-semibold text-navy">{{ $mahasiswa->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIM</p>
                <p class="font-semibold text-navy">{{ $mahasiswa->nim }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Program Studi</p>
                <p class="font-semibold text-navy">{{ $mahasiswa->program_studi }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Semester Aktif</p>
                <p class="font-semibold text-navy">
                    @if($semesterAktif)
                        {{ $semesterAktif->tahun_ajaran }} - {{ $semesterAktif->semester }}
                    @else
                        <span class="text-red-500">Belum ada</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Daftar Dosen -->
    @if(isset($message))
        <div class="banner-info rounded-lg p-6 text-center">
            <svg class="w-16 h-16 mx-auto text-gold/50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-navy">{{ $message }}</p>
        </div>
    @elseif($dosens->count() == 0)
        <div class="banner-info rounded-lg p-6 text-center">
            <svg class="w-16 h-16 mx-auto text-gold/50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <p class="text-navy">Belum ada dosen yang terdaftar di semester ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dosens as $dosen)
                <div class="card-dosen rounded-xl overflow-hidden {{ $dosen->sudahVoting ? 'card-dosen-done' : '' }}">
                    <!-- Foto / Header -->
                    <div class="h-32 bg-gradient-navy relative">
                        <div class="absolute inset-0 card-dosen-overlay"></div>
                        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                            <div class="w-20 h-20 rounded-full border-4 border-white bg-white flex items-center justify-center overflow-hidden">
                                @if($dosen->foto)
                                    <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-navy text-xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                                @endif
                            </div>
                        </div>
                        @if($dosen->sudahVoting)
                            <div class="absolute top-3 right-3 badge-selesai px-3 py-1 rounded-full text-xs font-bold">
                                Selesai
                            </div>
                        @endif
                    </div>

                    <!-- Body -->
                    <div class="pt-12 px-4 pb-4 text-center">
                        <h4 class="font-bold text-navy text-lg">{{ $dosen->nama }}</h4>
                        <p class="text-gray-500 text-sm">{{ $dosen->nidn }}</p>
                        <span class="badge-prodi px-3 py-1 rounded-full text-xs font-medium mt-1 inline-block">
                            {{ $dosen->program_studi }}
                        </span>

                        <!-- Mata Kuliah yang diajar -->
                        <div class="mt-3 text-left">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Mata Kuliah:</p>
                            @foreach($dosen->mataKuliahs as $mk)
                                <div class="flex items-center justify-between text-sm py-1 border-b border-gray-50 last:border-0">
                                    <span class="text-navy">{{ $mk->nama }}</span>
                                    <span class="text-xs text-gray-400">{{ $mk->kelas ?? '-' }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Tombol -->
                        @if($dosen->sudahVoting)
                            <div class="mt-4 px-4 py-2 bg-gray-100 text-gray-500 rounded-lg text-sm font-medium">
                                ✓ Sudah Dinilai
                            </div>
                        @else
                            <a href="{{ route('mahasiswa.voting.create', $dosen->id) }}"
                               class="link-voting inline-block mt-4 px-6 py-2 border border-navy text-navy rounded-lg hover:bg-navy hover:text-white transition font-medium text-sm">
                                Mulai Penilaian
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Progress -->
    @if($dosens->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Progress Voting</span>
                <span class="text-gold font-bold">
                    {{ $dosens->filter(function($d) { return $d->sudahVoting; })->count() }} / {{ $dosens->count() }}
                </span>
            </div>
            <div class="w-full h-2 bg-gray-200 rounded-full mt-2 overflow-hidden">
                <div class="h-full bg-gradient-gold rounded-full transition-all duration-500"
                     style="width: {{ $dosens->count() > 0 ? ($dosens->filter(function($d) { return $d->sudahVoting; })->count() / $dosens->count() * 100) : 0 }}%">
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
