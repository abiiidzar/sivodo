@extends('layouts.app')

@section('title', 'Ranking Dosen')
@section('header', 'Ranking Dosen')

@section('content')
<div class="space-y-6">
    <!-- Toolbar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <form method="GET" action="{{ route('pimpinan.ranking') }}" class="flex flex-wrap items-center gap-4">
                <select name="prodi" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Prodi</option>
                    @foreach($prodiList as $prodi)
                        <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                            {{ $prodi }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">Filter</button>
                <a href="{{ route('pimpinan.ranking') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">Reset</a>
            </form>
            <div class="flex flex-wrap items-center gap-3">
                @if(count($rankingData) > 0)
                    <a href="{{ route('pimpinan.ranking.export-pdf', request()->all()) }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export PDF
                    </a>
                    <a href="{{ route('pimpinan.ranking.export-excel', request()->all()) }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Excel
                    </a>
                @endif
            </div>
        </div>
        <div class="mt-3 text-sm text-gray-500">
            Total Dosen: <span class="font-semibold text-navy">{{ count($rankingData) }}</span>
        </div>
    </div>

    <!-- Ranking Table -->
    @if(count($rankingData) == 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-400">Belum ada data ranking</p>
            <p class="text-sm text-gray-400 mt-1">Ranking akan muncul setelah ada voting</p>
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
@endsection
