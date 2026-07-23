@extends('layouts.app')

@section('title', 'Hasil Penilaian Dosen')
@section('header', 'Hasil Penilaian Dosen')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('mahasiswa.hasil') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="flex items-center h-11 border border-gray-300 rounded-lg overflow-hidden">
                    <div class="flex items-center justify-center w-10 bg-gray-100">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Cari Nama Dosen..."
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
            <a href="{{ route('mahasiswa.hasil') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">Reset</a>
            <span class="text-sm text-gray-500 ml-auto">Total: {{ $dosens->count() }} dosen</span>
        </form>
    </div>

    @if($dosens->count() == 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <p class="text-gray-400">Belum ada hasil penilaian dosen</p>
            <p class="text-sm text-gray-400 mt-1">Hasil akan muncul setelah ada mahasiswa yang memberikan voting</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dosens as $dosen)
            <a href="{{ route('mahasiswa.hasil.show', $dosen->id) }}" class="block card-dosen rounded-xl overflow-hidden hover:shadow-lg transition">
                <div class="h-28 bg-gradient-navy relative">
                    <div class="absolute inset-0 card-dosen-overlay"></div>
                    <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                        <div class="w-20 h-20 rounded-full border-4 border-white bg-white flex items-center justify-center overflow-hidden">
                            @if($dosen->foto)
                                <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-navy text-xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-12 px-4 pb-4 text-center">
                    <h4 class="font-bold text-navy text-lg">{{ $dosen->nama }}</h4>
                    <p class="text-gray-500 text-sm">{{ $dosen->nidn }}</p>
                    <span class="badge-prodi px-3 py-1 rounded-full text-xs font-medium mt-1 inline-block">
                        {{ $dosen->program_studi }}
                    </span>

                    <div class="mt-3 flex items-center justify-center space-x-4">
                        <div>
                            <p class="text-xs text-gray-400">Rata-rata</p>
                            <p class="text-2xl font-bold text-gold">{{ number_format($dosen->rata_rata, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Voting</p>
                            <p class="text-lg font-bold text-navy">{{ $dosen->total_voting }}</p>
                        </div>
                    </div>

                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-medium text-white {{
                        $dosen->kategori == 'Sangat Memuaskan' ? 'bg-emerald-500' :
                        ($dosen->kategori == 'Memuaskan' ? 'bg-blue-500' :
                        ($dosen->kategori == 'Puas' ? 'bg-yellow-500' :
                        ($dosen->kategori == 'Cukup' ? 'bg-orange-500' : 'bg-red-500')))
                    }}">
                        {{ $dosen->kategori }}
                    </span>
                </div>
            </a>
            @endforeach
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
