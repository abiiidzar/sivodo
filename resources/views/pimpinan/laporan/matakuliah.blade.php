@extends('layouts.app')

@section('title', 'Laporan Mata Kuliah')
@section('header', 'Laporan Mata Kuliah')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <form method="GET" action="{{ route('pimpinan.laporan.matakuliah') }}" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Semester</label>
                    <select name="semester" class="rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm h-11">
                        <option value="">Semua Semester</option>
                        <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">Filter</button>
                <a href="{{ route('pimpinan.laporan.matakuliah') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">Reset</a>
            </form>
            @if(isset($matakuliahs) && $matakuliahs->count() > 0)
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('pimpinan.laporan.export-pdf-matakuliah', request()->all()) }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export PDF
                    </a>
                    <a href="{{ route('pimpinan.laporan.export-excel-matakuliah', request()->all()) }}"
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
                <!-- ... tabel tetap sama ... -->
            </table>
        </div>
    </div>
</div>
@endsection
