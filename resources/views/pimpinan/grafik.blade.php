@extends('layouts.app')

@section('title', 'Grafik & Chart')
@section('header', 'Grafik & Chart')

@section('content')
<div class="space-y-6">
    <!-- Chart 1: Bar Chart Top 10 Dosen -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-4">📊 Top 10 Dosen Berdasarkan Nilai</h4>
        <div class="h-80">
            <canvas id="topDosenChart"></canvas>
        </div>
    </div>

    <!-- Chart 2: Pie Chart Distribusi Kategori -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-navy mb-4">📈 Distribusi Kategori Penilaian</h4>
            <div class="h-64">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-navy mb-4">📋 Ringkasan Kategori</h4>
            <div class="space-y-3">
                @foreach($kategoriData as $kategori => $jumlah)
                <div class="flex items-center justify-between p-2 border-b border-gray-100">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full
                            {{ $kategori == 'Sangat Memuaskan' ? 'bg-emerald-500' :
                               ($kategori == 'Memuaskan' ? 'bg-blue-500' :
                               ($kategori == 'Puas' ? 'bg-yellow-500' :
                               ($kategori == 'Cukup' ? 'bg-orange-500' : 'bg-red-500'))) }}">
                        </span>
                        <span class="text-sm text-navy">{{ $kategori }}</span>
                    </div>
                    <span class="text-sm font-bold text-navy">{{ $jumlah }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart 1: Bar Chart
    const ctx1 = document.getElementById('topDosenChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Rata-rata Nilai',
                data: @json($chartData),
                backgroundColor: @json($chartColors),
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: { stepSize: 0.5 }
                }
            }
        }
    });

    // Chart 2: Pie Chart
    const ctx2 = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: @json(array_keys($kategoriData)),
            datasets: [{
                data: @json(array_values($kategoriData)),
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endpush
@endsection
