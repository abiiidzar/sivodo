@extends('layouts.app')

@section('title', 'Riwayat Voting')
@section('header', 'Riwayat Voting')

@section('content')
<div class="space-y-6">
    <!-- Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('mahasiswa.riwayat') }}" class="flex flex-wrap items-center gap-4">
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
            <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">Cari</button>
            <a href="{{ route('mahasiswa.riwayat') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">Reset</a>
            <span class="text-sm text-gray-500 ml-auto">Total: {{ $votings->total() }} voting</span>
        </form>
    </div>

    @if($votings->count() == 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-400">Belum ada riwayat voting</p>
            <a href="{{ route('mahasiswa.voting') }}" class="text-gold hover:underline text-sm mt-2 inline-block">Mulai voting sekarang</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($votings as $voting)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if($voting->dosen->foto)
                                <img src="{{ Storage::url($voting->dosen->foto) }}" alt="{{ $voting->dosen->nama }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gold font-bold">{{ substr($voting->dosen->nama, 0, 2) }}</span>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-navy">{{ $voting->dosen->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $voting->mataKuliah->nama }}</p>
                            <div class="flex items-center space-x-3 mt-1">
                                <span class="text-xs text-gray-400">{{ $voting->semester->tahun_ajaran }} - {{ $voting->semester->semester }}</span>
                                <span class="text-xs text-gray-400">{{ $voting->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Nilai</p>
                            <p class="text-lg font-bold text-gold">{{ number_format($voting->rata_rata, 2) }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium text-white {{ $voting->kategori['class'] }}">
                            {{ $voting->kategori['label'] }}
                        </span>
                        <a href="{{ route('mahasiswa.riwayat.show', $voting->id) }}" class="text-gold hover:text-gold/80 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $votings->links() }}
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
