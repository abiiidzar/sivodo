@extends('layouts.app')

@section('title', 'Ranking Dosen')
@section('header', 'Ranking Dosen')

@section('content')
<div class="space-y-6">
    <!-- Toolbar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('mahasiswa.ranking') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="flex items-center h-11 border border-gray-300 rounded-lg overflow-hidden">
                    <div class="flex items-center justify-center w-10 bg-gray-100">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Cari Nama/NIDN..."
                               value="{{ request('search') }}"
                               class="w-full h-full px-3 border-0 focus:ring-0 focus:outline-none">
                    </div>
                </div>
            </div>

            <select name="prodi" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                <option value="">Semua Prodi</option>
                @foreach($prodiList as $prodi)
                    <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                        {{ $prodi }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">Cari</button>
            <a href="{{ route('mahasiswa.ranking') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">Reset</a>
            <span class="text-sm text-gray-500 ml-auto">Total: {{ count($rankingData) }} dosen</span>
        </form>
    </div>

    <!-- Ranking -->
    @if(count($rankingData) == 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-400">Belum ada data ranking</p>
            <p class="text-sm text-gray-400 mt-1">Ranking akan muncul setelah ada mahasiswa yang memberikan voting</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="text-left py-3 px-4 text-gray-500 font-medium w-16">Rank</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Dosen</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Program Studi</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Rata-rata</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Voting</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-medium">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rankingData as $item)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-3 px-4">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm
                                    {{ $item->rank == 1 ? 'rank-1' : ($item->rank == 2 ? 'rank-2' : ($item->rank == 3 ? 'rank-3' : 'rank-default')) }}">
                                    {{ $item->medal }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($item->foto)
                                            <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-gold text-sm font-bold">{{ substr($item->nama, 0, 2) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-navy">{{ $item->nama }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->nidn }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="badge-prodi px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $item->program_studi }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-gold font-bold text-lg">{{ number_format($item->rata_rata, 2) }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-navy font-medium">{{ $item->total_voting }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium text-white {{
                                    $item->kategori == 'Sangat Memuaskan' ? 'bg-emerald-500' :
                                    ($item->kategori == 'Memuaskan' ? 'bg-blue-500' :
                                    ($item->kategori == 'Puas' ? 'bg-yellow-500' :
                                    ($item->kategori == 'Cukup' ? 'bg-orange-500' : 'bg-red-500')))
                                }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistik -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-2">
            <span class="text-sm text-gray-500">Total Dosen: {{ count($rankingData) }}</span>
            <span class="text-sm text-gray-500">
                Rata-rata Tertinggi:
                <span class="text-gold font-bold">{{ count($rankingData) > 0 ? number_format($rankingData[0]->rata_rata, 2) : '-' }}</span>
            </span>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
</script>
@endpush
@endsection
