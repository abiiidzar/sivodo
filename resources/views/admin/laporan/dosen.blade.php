@extends('layouts.app')

@section('title', 'Laporan Dosen')
@section('header', 'Laporan Dosen')

@section('content')
<div class="space-y-6">

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET"
              action="{{ route('admin.laporan.dosen') }}"
              class="flex flex-wrap items-end gap-4">

            <!-- Program Studi -->
            <div>
                <label class="block text-xs text-gray-400 mb-1">
                    Program Studi
                </label>

                <select name="prodi"
                        class="rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm h-11">

                    <option value="">Semua Prodi</option>

                    @foreach($prodiList ?? [] as $prodi)
                        <option value="{{ $prodi }}"
                            {{ request('prodi') == $prodi ? 'selected' : '' }}>
                            {{ $prodi }}
                        </option>
                    @endforeach

                </select>
            </div>


            <!-- Status Dosen -->
            <div>
                <label class="block text-xs text-gray-400 mb-1">
                    Status Dosen
                </label>

                <select name="status"
                        class="rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm h-11">

                    <option value="">Semua Status</option>

                    <option value="PNS"
                        {{ request('status') == 'PNS' ? 'selected' : '' }}>
                        PNS
                    </option>

                    <option value="Yayasan"
                        {{ request('status') == 'Yayasan' ? 'selected' : '' }}>
                        Yayasan
                    </option>

                    <option value="Luar Biasa"
                        {{ request('status') == 'Luar Biasa' ? 'selected' : '' }}>
                        Luar Biasa
                    </option>

                </select>
            </div>


            <!-- Filter Voting -->
            <div>
                <label class="block text-xs text-gray-400 mb-1">
                    Filter Voting
                </label>

                <select name="filter_voting"
                        class="rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm h-11">

                    <option value="">Semua Dosen</option>

                    <option value="sudah"
                        {{ request('filter_voting') == 'sudah' ? 'selected' : '' }}>
                        Sudah Voting
                    </option>

                    <option value="belum"
                        {{ request('filter_voting') == 'belum' ? 'selected' : '' }}>
                        Belum Voting
                    </option>

                </select>
            </div>


            <!-- Tombol Filter -->
            <button type="submit"
                    class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">
                Filter
            </button>


            <!-- Tombol Reset -->
            <a href="{{ route('admin.laporan.dosen') }}"
               class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">
                Reset
            </a>


            <!-- Tombol Export -->
            @if(isset($dosens) && $dosens->count() > 0)

                <!-- Export PDF -->
                <a href="{{ route('admin.laporan.export-pdf-dosen', request()->all()) }}"
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium h-11">
                    Export PDF
                </a>


                <!-- Export Excel -->
                <a href="{{ route('admin.laporan.export-excel-dosen', request()->all()) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium h-11">
                    Export Excel
                </a>

            @endif

        </form>
    </div>


    <!-- Hasil Laporan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <!-- Header Tabel -->
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            No
                        </th>

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            Nama
                        </th>

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            NIDN
                        </th>

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            Program Studi
                        </th>

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            Status
                        </th>

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            Voting
                        </th>

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            Rata-rata
                        </th>

                        <th class="text-left py-3 px-4 text-gray-500 font-medium">
                            Kategori
                        </th>

                    </tr>
                </thead>


                <!-- Isi Tabel -->
                <tbody>

                    @forelse($dosens ?? [] as $index => $dosen)

                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">

                        <!-- No -->
                        <td class="py-3 px-4">
                            {{ $index + 1 }}
                        </td>


                        <!-- Nama -->
                        <td class="py-3 px-4 font-medium text-navy">
                            {{ $dosen->nama }}
                        </td>


                        <!-- NIDN -->
                        <td class="py-3 px-4">
                            {{ $dosen->nidn }}
                        </td>


                        <!-- Program Studi -->
                        <td class="py-3 px-4">
                            {{ $dosen->program_studi }}
                        </td>


                        <!-- Status -->
                        <td class="py-3 px-4">

                            <span class="px-2 py-0.5 rounded-full text-xs
                                {{ $dosen->status_dosen == 'PNS'
                                    ? 'bg-blue-50 text-blue-700'
                                    : ($dosen->status_dosen == 'Yayasan'
                                        ? 'bg-green-50 text-green-700'
                                        : 'bg-purple-50 text-purple-700') }}">

                                {{ $dosen->status_dosen }}

                            </span>

                        </td>


                        <!-- Total Voting -->
                        <td class="py-3 px-4">
                            {{ $dosen->total_voting ?? 0 }}
                        </td>


                        <!-- Rata-rata -->
                        <td class="py-3 px-4">

                            <span class="text-gold font-bold">
                                {{ number_format($dosen->rata_rata ?? 0, 2) }}
                            </span>

                        </td>


                        <!-- Kategori -->
                        <td class="py-3 px-4">

                            <span class="px-2 py-0.5 rounded-full text-xs text-white
                                {{ ($dosen->kategori ?? '') == 'Sangat Memuaskan'
                                    ? 'bg-emerald-500'
                                    : (($dosen->kategori ?? '') == 'Memuaskan'
                                        ? 'bg-blue-500'
                                        : (($dosen->kategori ?? '') == 'Puas'
                                            ? 'bg-yellow-500'
                                            : (($dosen->kategori ?? '') == 'Cukup'
                                                ? 'bg-orange-500'
                                                : 'bg-red-500'))) }}">

                                {{ $dosen->kategori ?? '-' }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    <!-- Jika Tidak Ada Data -->
                    <tr>

                        <td colspan="8"
                            class="py-12 text-center text-gray-400">

                            Tidak ada data

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection
