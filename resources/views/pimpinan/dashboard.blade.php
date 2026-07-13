<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1a2744] leading-tight">
            {{ __('Dashboard Pimpinan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500">Total Voting</div>
                    <div class="text-3xl font-bold text-[#1a2744]">{{ $totalVoting }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500">Mahasiswa Sudah Voting</div>
                    <div class="text-3xl font-bold text-[#1a2744]">{{ $totalMahasiswaVoting }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500">Rata-rata Kepuasan</div>
                    <div class="text-3xl font-bold text-[#c9a227]">{{ number_format($rataRataKepuasan, 2) }}</div>
                </div>
            </div>

            <!-- Dosen Terbaik & Perlu Pembinaan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-[#1a2744] mb-4">🏆 Dosen Terbaik</h3>
                    <div class="space-y-3">
                        @foreach($dosenTerbaik as $index => $dosen)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-lg">
                                        @if($index == 0) 🥇
                                        @elseif($index == 1) 🥈
                                        @elseif($index == 2) 🥉
                                        @endif
                                    </span>
                                    <div>
                                        <p class="font-semibold">{{ $dosen->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $dosen->program_studi }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-[#c9a227]">{{ number_format($dosen->votings_avg_rata_rata ?? 0, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ $dosen->votings_count }} voting</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-[#1a2744] mb-4">📋 Dosen Perlu Pembinaan</h3>
                    <div class="space-y-3">
                        @foreach($dosenPerluPembinaan as $dosen)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded">
                                <div>
                                    <p class="font-semibold">{{ $dosen->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $dosen->program_studi }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-red-600">{{ number_format($dosen->votings_avg_rata_rata ?? 0, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ $dosen->votings_count }} voting</div>
                                </div>
                            </div>
                        @endforeach
                        @if($dosenPerluPembinaan->isEmpty())
                            <p class="text-gray-500 text-center py-4">✨ Semua dosen sudah baik!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
