@extends('layouts.app')

@section('title', 'Analisis Kinerja Dosen')
@section('header', 'Analisis Kinerja Dosen')

@section('content')
<div class="space-y-6">
    <!-- Info READ-ONLY -->
    <div class="banner-info rounded-lg p-4">
        <div class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-navy">Analisis Detail Kinerja Dosen</p>
                <p class="text-sm text-gray-600">Klik tombol "Analisis" untuk melihat detail penilaian per pertanyaan dan mengetahui kelemahan dosen.</p>
                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Mode <strong>Read-Only</strong> - Anda hanya dapat melihat data, tidak dapat mengubah</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400">Total Dosen</p>
            <p class="text-2xl font-bold text-navy">{{ $totalDosen }}</p>
        </div>
        <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400">Total Voting</p>
            <p class="text-2xl font-bold text-navy">{{ $totalVoting }}</p>
        </div>
        <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400">Mahasiswa Voting</p>
            <p class="text-2xl font-bold text-navy">{{ $totalMahasiswaVoting }}</p>
        </div>
        <div class="stat-card rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400">Rata-rata Kepuasan</p>
            <p class="text-2xl font-bold text-gold">{{ number_format($rataRataKeseluruhan, 2) }}</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center w-full sm:w-64 h-11 border border-gray-300 rounded-lg overflow-hidden">
                    <div class="flex items-center justify-center w-10 bg-gray-100">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="text" id="searchDosen" placeholder="Cari NIDN atau Nama..."
                               value="{{ request('search') }}"
                               class="w-full h-full px-3 border-0 focus:ring-0 focus:outline-none">
                    </div>
                </div>

                <select id="filterProdi" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Prodi</option>
                    @foreach($prodiList as $prodi)
                        <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                    @endforeach
                </select>

                <select id="filterVoting" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Dosen</option>
                    <option value="yes" {{ request('has_voting') == 'yes' ? 'selected' : '' }}>Sudah Divoting</option>
                    <option value="no" {{ request('has_voting') == 'no' ? 'selected' : '' }}>Belum Divoting</option>
                </select>

                <button id="btnSearch" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">
                    Cari
                </button>
                <button id="btnReset" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Foto</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">NIDN</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Nama Dosen</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Program Studi</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Total Voting</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosens as $index => $dosen)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $loop->iteration + ($dosens->currentPage() - 1) * $dosens->perPage() }}</td>
                        <td class="py-3 px-4">
                            <div class="w-10 h-10 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden">
                                @if($dosen->foto)
                                    <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gold text-sm font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4 font-mono text-xs">{{ $dosen->nidn }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $dosen->nama }}</td>
                        <td class="py-3 px-4">
                            <span class="badge-prodi px-3 py-1 rounded-full text-xs font-medium">{{ $dosen->program_studi }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $dosen->votings_count }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('pimpinan.analisis.show', $dosen->id) }}"
                               class="inline-flex items-center gap-1 px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Analisis
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-sm">Belum ada data dosen</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-100">
            {{ $dosens->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('btnSearch').addEventListener('click', function() {
        const search = document.getElementById('searchDosen').value;
        const prodi = document.getElementById('filterProdi').value;
        const voting = document.getElementById('filterVoting').value;
        let url = '{{ route("pimpinan.analisis.index") }}?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (prodi) url += 'prodi=' + encodeURIComponent(prodi) + '&';
        if (voting) url += 'has_voting=' + encodeURIComponent(voting);
        window.location.href = url;
    });

    document.getElementById('btnReset').addEventListener('click', function() {
        window.location.href = '{{ route("pimpinan.analisis.index") }}';
    });

    document.getElementById('searchDosen').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('btnSearch').click();
        }
    });
</script>
@endpush
@endsection
