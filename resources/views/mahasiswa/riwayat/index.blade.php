@extends('layouts.app')

@section('title', 'Riwayat Voting')
@section('header', 'Riwayat Voting')

@section('content')
<div class="space-y-6">
    <!-- Toolbar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('mahasiswa.riwayat') }}" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex items-center h-11 border border-gray-300 rounded-lg overflow-hidden flex-1 min-w-[180px]">
                <div class="flex items-center justify-center w-10 bg-gray-100">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Cari Nama atau NIDN Dosen..."
                           value="{{ request('search') }}"
                           class="w-full h-full px-3 border-0 focus:ring-0 focus:outline-none">
                </div>
            </div>

            <!-- Filter Semester Mahasiswa -->
            <select name="semester" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                <option value="">Semua Semester</option>
                @foreach($semesterList as $semester)
                    <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                        Semester {{ $semester }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">
                Cari
            </button>
            <a href="{{ route('mahasiswa.riwayat') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">
                Reset
            </a>

            <span class="text-sm text-gray-500 ml-auto">
                Total: <strong class="text-navy">{{ $votings->total() }}</strong> voting
            </span>
        </form>
    </div>

    <!-- Alert jika belum ada data -->
    @if($votings->count() == 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-400">Belum ada riwayat voting</p>
            <a href="{{ route('mahasiswa.voting') }}" class="text-gold hover:underline text-sm mt-2 inline-block">Mulai voting sekarang</a>
        </div>
    @else
        <!-- Tabel Riwayat Voting -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Dosen</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Mata Kuliah</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Semester</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Nilai</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Kategori</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Tanggal</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($votings as $index => $voting)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $loop->iteration + ($votings->currentPage() - 1) * $votings->perPage() }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($voting->dosen->foto)
                                            <img src="{{ Storage::url($voting->dosen->foto) }}" alt="{{ $voting->dosen->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-gold text-xs font-bold">{{ substr($voting->dosen->nama, 0, 2) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-navy text-sm">{{ $voting->dosen->nama }}</p>
                                        <p class="text-xs text-gray-400">{{ $voting->dosen->nidn }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <p class="text-sm text-navy">{{ $voting->mataKuliah->nama }}</p>
                                <p class="text-xs text-gray-400">{{ $voting->mataKuliah->kode }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-sm font-medium text-navy"> {{ $voting->mahasiswa->semester }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex flex-col items-start">
                                    <span class="text-lg font-bold text-gold">{{ number_format($voting->rata_rata, 2) }}</span>
                                    <span class="text-xs text-gray-400">Skor: {{ $voting->total_skor }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium text-white {{ $voting->kategori['class'] }}">
                                    {{ $voting->kategori['label'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-xs text-gray-500">
                                {{ $voting->created_at->format('d M Y') }}
                                <span class="block text-gray-400 text-[10px]">{{ $voting->created_at->format('H:i:s') }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('mahasiswa.riwayat.show', $voting->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-xs font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $votings->links() }}
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Enter key untuk submit form
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });

    // Auto submit saat filter semester berubah
    document.querySelector('select[name="semester"]').addEventListener('change', function() {
        this.closest('form').submit();
    });
</script>
@endpush
@endsection
