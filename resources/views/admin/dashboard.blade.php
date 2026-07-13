<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1a2744] leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-[#1a2744]">
                    <div class="text-sm text-gray-500">Total Dosen</div>
                    <div class="text-3xl font-bold text-[#1a2744]">{{ $totalDosen }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-[#c9a227]">
                    <div class="text-sm text-gray-500">Total Mahasiswa</div>
                    <div class="text-3xl font-bold text-[#1a2744]">{{ $totalMahasiswa }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500">Total Mata Kuliah</div>
                    <div class="text-3xl font-bold text-[#1a2744]">{{ $totalMataKuliah }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="text-sm text-gray-500">Total Voting</div>
                    <div class="text-3xl font-bold text-[#1a2744]">{{ $totalVoting }}</div>
                </div>
            </div>

            <!-- Grafik & Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-[#1a2744] mb-4">Grafik Voting</h3>
                    <canvas id="votingChart"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-[#1a2744] mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-3">
                        @foreach($recentActivities as $log)
                            <div class="flex items-center gap-3 p-2 bg-gray-50 rounded">
                                <div class="w-10 h-10 rounded-full bg-[#1a2744] text-white flex items-center justify-center text-xs">
                                    {{ substr($log->user->nama ?? 'User', 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $log->aktivitas }}</p>
                                    <p class="text-xs text-gray-500">{{ $log->deskripsi }}</p>
                                    <p class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('votingChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $votingData->pluck('date')->toJson() !!},
                datasets: [{
                    label: 'Jumlah Voting',
                    data: {!! $votingData->pluck('total')->toJson() !!},
                    borderColor: '#1a2744',
                    backgroundColor: 'rgba(26,39,68,0.1)',
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
