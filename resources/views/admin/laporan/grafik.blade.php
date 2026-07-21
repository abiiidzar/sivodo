@extends('layouts.app')

@section('title', 'Grafik & Ranking')
@section('header', 'Grafik & Ranking Dosen')

@section('content')
<div class="space-y-6">
    <!-- Tombol Export -->
                @if(isset($rankingData) && count($rankingData) > 0)
                <div class="flex gap-3">
                    <a href="{{ route('admin.laporan.export-pdf-ranking') }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        Export PDF Ranking
                    </a>
                    <a href="{{ route('admin.laporan.export-excel-ranking') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        Export Excel Ranking
                    </a>
                </div>
            @endif

    <!-- Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-4">📊 Top 10 Dosen Berdasarkan Nilai</h4>
        <div class="h-80">
            <canvas id="rankingChart"></canvas>
        </div>
    </div>

    <!-- Ranking Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h4 class="font-semibold text-navy">🏆 Ranking Dosen</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Rank</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Nama</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Program Studi</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Voting</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Rata-rata</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rankingData ?? [] as $item)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">
                            <span class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm
                                {{ ($item->rank ?? 0) == 1 ? 'rank-1' : (($item->rank ?? 0) == 2 ? 'rank-2' : (($item->rank ?? 0) == 3 ? 'rank-3' : 'rank-default')) }}">
                                {{ $item->medal ?? $item->rank ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $item->nama }}</td>
                        <td class="py-3 px-4">{{ $item->program_studi }}</td>
                        <td class="py-3 px-4">{{ $item->total_voting }}</td>
                        <td class="py-3 px-4">
                            <span class="text-gold font-bold">{{ number_format($item->rata_rata, 2) }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded-full text-xs text-white
                                {{ ($item->kategori ?? '') == 'Sangat Memuaskan' ? 'bg-emerald-500' :
                                   (($item->kategori ?? '') == 'Memuaskan' ? 'bg-blue-500' :
                                   (($item->kategori ?? '') == 'Puas' ? 'bg-yellow-500' :
                                   (($item->kategori ?? '') == 'Cukup' ? 'bg-orange-500' : 'bg-red-500'))) }}">
                                {{ $item->kategori ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm">Belum ada data ranking</p>
                            <p class="text-xs text-gray-400 mt-1">Ranking akan muncul setelah ada voting</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rankingChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Rata-rata Nilai',
                data: @json($chartData ?? []),
                backgroundColor: [
                    '#c9a227', '#1a2744', '#3b82f6', '#10b981', '#f59e0b',
                    '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'
                ],
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 0.5,
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
