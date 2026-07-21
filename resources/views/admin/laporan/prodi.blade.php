@extends('layouts.app')

@section('title', 'Laporan Program Studi')
@section('header', 'Laporan Program Studi')

@section('content')
<div class="space-y-6">
    <!-- Toolbar dengan Tombol Export -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">
                    Total Program Studi: <span class="font-semibold text-navy">{{ isset($data) ? count($data) : 0 }}</span>
                </p>
            </div>
                        @if(isset($data) && count($data) > 0)
                <div class="mt-4 flex gap-3">
                    <a href="{{ route('admin.laporan.export-pdf-prodi', request()->all()) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        Export PDF
                    </a>
                    <a href="{{ route('admin.laporan.export-excel-prodi', request()->all()) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        Export Excel
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Tabel -->
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
                    @forelse($data as $index => $item)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $item->program_studi }}</td>
                        <td class="py-3 px-4">{{ $item->total_dosen }}</td>
                        <td class="py-3 px-4">{{ $item->dosen_with_voting }}</td>
                        <td class="py-3 px-4">{{ $item->total_voting }}</td>
                        <td class="py-3 px-4">
                            <span class="text-gold font-bold">{{ number_format($item->rata_rata, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                            </svg>
                            <p class="text-sm">Belum ada data program studi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
