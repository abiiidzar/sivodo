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
        <!-- ... tabel tetap sama ... -->
    </div>
</div>
@endsection
