@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-[#1a2744]">
                <div class="text-sm text-gray-500">Total Dosen</div>
                <div class="text-3xl font-bold text-[#1a2744]">{{ $total_dosen ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-[#c9a227]">
                <div class="text-sm text-gray-500">Total Mahasiswa</div>
                <div class="text-3xl font-bold text-[#1a2744]">{{ $total_mahasiswa ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="text-sm text-gray-500">Total Mata Kuliah</div>
                <div class="text-3xl font-bold text-[#1a2744]">{{ $total_mata_kuliah ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="text-sm text-gray-500">Total Voting</div>
                <div class="text-3xl font-bold text-[#1a2744]">{{ $total_voting ?? 0 }}</div>
            </div>
        </div>

        <!-- Grafik & Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-[#1a2744] mb-4">Grafik Voting</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="votingChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-[#1a2744] mb-4">Aktivitas Terbaru</h3>
                <div class="space-y-3">
                    @forelse($recent_activities ?? [] as $log)
                        <div class="flex items-center gap-3 p-2 bg-gray-50 rounded">
                            <div class="w-10 h-10 rounded-full bg-[#1a2744] text-white flex items-center justify-center text-xs">
                                {{ substr($log->user->nama ?? 'User', 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $log->aktivitas ?? 'Aktivitas' }}</p>
                                <p class="text-xs text-gray-500">{{ $log->deskripsi ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Loaded - Initializing chart...');

        const canvas = document.getElementById('votingChart');
        if (!canvas) {
            console.error('Canvas element #votingChart tidak ditemukan!');
            return;
        }

        console.log('Canvas ditemukan, memproses data...');

        try {
            const votingData = @json($votingData ?? ['labels' => [], 'data' => []]);
            console.log('Voting Data:', votingData);

            // Cek data
            if (!votingData.labels || votingData.labels.length === 0) {
                console.warn('Data voting kosong, menggunakan data dummy');
                // Gunakan data dummy
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                votingData.labels = months;
                votingData.data = months.map(() => 0);
            }

            // Cek apakah semua data 0
            const totalData = votingData.data.reduce((a, b) => a + b, 0);
            if (totalData === 0) {
                console.warn('Semua data bernilai 0, menampilkan pesan kosong');
                const container = canvas.parentElement;
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full">
                        <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-gray-500">Belum ada data voting</p>
                        <p class="text-gray-400 text-sm">Data akan muncul setelah mahasiswa melakukan voting</p>
                    </div>
                `;
                return;
            }

            // Buat chart
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: votingData.labels,
                    datasets: [{
                        label: 'Jumlah Voting',
                        data: votingData.data,
                        backgroundColor: 'rgba(26, 39, 68, 0.7)',
                        borderColor: '#1a2744',
                        borderWidth: 2,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(26, 39, 68, 0.9)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: { size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { size: 11 }
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 10 }
                            }
                        }
                    }
                }
            });

            console.log('Chart berhasil dibuat!');
        } catch (error) {
            console.error('Error saat membuat chart:', error);
            const container = canvas.parentElement;
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-red-500">
                    <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Error: ${error.message}</p>
                </div>
            `;
        }
    });
</script>
@endpush
