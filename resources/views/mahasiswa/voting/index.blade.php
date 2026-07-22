@extends('layouts.app')

@section('title', 'Daftar Dosen')
@section('header', 'Daftar Dosen untuk Voting')

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
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <!-- Informasi Semester Aktif -->
    <div class="banner-info rounded-xl p-4">
        <div class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-navy">Semester Aktif</p>
                <p class="text-sm text-gray-600">{{ $semesterAktif->tahun_ajaran ?? 'Belum ada semester aktif' }} - {{ $semesterAktif->semester ?? '-' }}</p>
                <p class="text-xs text-gray-400 mt-1">Pilih dosen di bawah untuk memberikan penilaian</p>
            </div>
        </div>
    </div>

    <!-- Progress Voting -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex-1 w-full">
                <div class="flex justify-between items-center mb-3">
                <h4 class="font-semibold text-navy">Progress Voting</h4>
                <span class="text-gold font-bold text-lg">{{ $progress ?? 0 }}%</span>  {{-- ← pakai $progress --}}
            </div>
            <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-gold rounded-full transition-all duration-700" style="width: {{ $progress ?? 0 }}%"></div>
            </div>
            <p class="text-sm text-gray-500 mt-2">{{ $sudah_voting ?? 0 }} dari {{ $total_dosen ?? 0 }} dosen telah dinilai</p>
            </div>
            <div class="flex items-center gap-4 text-sm whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="text-gray-600">Sudah: <strong class="text-emerald-700">{{ $sudah_voting ?? 0 }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="text-gray-600">Belum: <strong class="text-red-700">{{ $belum_voting ?? 0 }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Dosen -->
    @if(isset($message))
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500">{{ $message }}</p>
        </div>
    @elseif($dosens->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dosens as $dosen)
                <div class="card-dosen rounded-xl overflow-hidden {{ $dosen->sudahVoting ? 'card-dosen-done' : '' }}">
                    <div class="relative">
                        <!-- Foto dengan overlay -->
                        <div class="h-48 bg-gray-100 relative">
                            @if($dosen->foto)
                                <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gold-10 flex items-center justify-center">
                                    <span class="text-gold text-5xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                                </div>
                            @endif
                            <div class="card-dosen-overlay absolute inset-0"></div>
                            <!-- Badge Status -->
                            @if($dosen->sudahVoting)
                                <div class="absolute top-3 right-3 badge-selesai px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Selesai
                                </div>
                            @endif
                            <!-- Info di overlay bawah -->
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <span class="badge-prodi px-3 py-1 rounded-full text-xs font-medium">{{ $dosen->program_studi }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <h5 class="font-bold text-navy text-lg">{{ $dosen->nama }}</h5>
                        <p class="text-sm text-gray-500">NIDN: {{ $dosen->nidn }}</p>

                        <!-- Mata Kuliah yang diajar -->
                        <div class="mt-2 space-y-1">
                            @foreach($dosen->mataKuliahs->take(2) as $mk)
                                <span class="inline-block text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $mk->nama }}</span>
                            @endforeach
                            @if($dosen->mataKuliahs->count() > 2)
                                <span class="inline-block text-xs text-gray-400">+{{ $dosen->mataKuliahs->count() - 2 }} lagi</span>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            @if($dosen->sudahVoting)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-400">Sudah memberikan penilaian</span>
                                    <span class="text-emerald-600 font-medium">Terima kasih</span>
                                </div>
                            @else
                                <a href="{{ route('mahasiswa.voting.create', $dosen->id) }}"
                                   class="flex items-center justify-center space-x-2 w-full px-4 py-2.5 border border-navy text-navy rounded-lg hover:bg-navy hover:text-white transition text-sm font-medium group">
                                    <svg class="w-5 h-5 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                    <span>Mulai Penilaian</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <p class="text-gray-500">Belum ada dosen yang tersedia untuk semester ini</p>
        </div>
    @endif
</div>
@endsection
