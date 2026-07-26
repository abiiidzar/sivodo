@extends('layouts.app')

@section('title', 'Laporan Program Studi')
@section('header', 'Laporan Program Studi')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="text-sm text-gray-500">Total Program Studi: {{ isset($data) ? count($data) : 0 }}</span>
            </div>
            @if(isset($data) && count($data) > 0)
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('pimpinan.laporan.export-pdf-prodi', request()->all()) }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export PDF
                    </a>
                    <a href="{{ route('pimpinan.laporan.export-excel-prodi', request()->all()) }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Excel
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Tabel tetap sama -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Program Studi</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Total Dosen</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Dosen dengan Voting</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Total Voting</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Rata-rata</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $index => $item)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">
                                <span class="badge-prodi px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $item->program_studi }}
                                </span>
                        </td>
                        <td class="py-3 px-4">{{ $item->total_dosen }}</td>
                        <td class="py-3 px-4">{{ $item->dosen_with_voting }}</td>
                        <td class="py-3 px-4">{{ $item->total_voting }}</td>
                        <td class="py-3 px-4">
                            <span class="text-gold font-bold ">
                                {{ number_format($item->rata_rata, 2) }}
                            </span>
                        </tdclass=>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
