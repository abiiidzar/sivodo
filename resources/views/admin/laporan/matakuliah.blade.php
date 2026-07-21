@extends('layouts.app')

@section('title', 'Laporan Mata Kuliah')
@section('header', 'Laporan Mata Kuliah')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.laporan.matakuliah') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs text-gray-400 mb-1">Semester</label>
                <select name="semester" class="rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm h-11">
                    <option value="">Semua Semester</option>
                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Dosen Pengampu</label>
                <select name="dosen_id" class="rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm h-11">
                    <option value="">Semua Dosen</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">Filter</button>
            <a href="{{ route('admin.laporan.matakuliah') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">Reset</a>

            <!-- TOMBOL EXPORT -->
                        @if(isset($matakuliahs) && $matakuliahs->count() > 0)
                <a href="{{ route('admin.laporan.export-pdf-matakuliah', request()->all()) }}"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium h-11">
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.export-excel-matakuliah', request()->all()) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium h-11">
                    Export Excel
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Kode</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Mata Kuliah</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Dosen</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Semester</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Kelas</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Voting</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matakuliahs as $index => $mk)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-mono text-xs">{{ $mk->kode }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $mk->nama }}</td>
                        <td class="py-3 px-4">{{ $mk->dosen->nama ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $mk->semester }}</td>
                        <td class="py-3 px-4">{{ $mk->kelas ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $mk->total_voting }}</td>
                        <td class="py-3 px-4">
                            <span class="text-gold font-bold">{{ number_format($mk->rata_rata, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="py-12 text-center text-gray-400">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
