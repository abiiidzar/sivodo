@extends('layouts.app')

@section('title', 'Analisis Dosen')
@section('header', 'Analisis Kinerja Dosen')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Dosen -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                @if($dosen->foto)
                    <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold text-2xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-bold text-navy">{{ $dosen->nama }}</h3>
                <p class="text-sm text-gray-500">NIDN: {{ $dosen->nidn }} | {{ $dosen->program_studi }}</p>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-sm text-gray-500">Total Voting: <strong class="text-navy">{{ $totalVoting }}</strong></span>
                    <span class="text-sm text-gray-500">Rata-rata: <strong class="text-gold">{{ number_format($rataRataKeseluruhan, 2) }}</strong></span>
                </div>
            </div>
            <div class="ml-auto">
                <a href="{{ route('admin.analisis.index') }}"
                   class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Ringkasan Kelemahan -->
    @if(count($kelemahan) > 0)
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <h4 class="font-semibold text-red-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ count($kelemahan) }} Aspek yang Perlu Diperhatikan
            </h4>
            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($kelemahan as $item)
                    <div class="bg-white rounded-lg p-3 border border-red-100">
                        <p class="text-sm font-medium text-navy">{{ $item['pertanyaan']->kategori }}</p>
                        <p class="text-xs text-gray-500">{{ $item['pertanyaan']->pertanyaan }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-sm font-bold text-red-600">{{ number_format($item['rata_rata'], 2) }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $item['kategori']['class'] }} text-white">
                                {{ $item['kategori']['label'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6">
            <div class="flex items-center gap-2 text-emerald-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">Semua aspek penilaian berada di atas rata-rata 3.5. Tidak ada kelemahan signifikan.</span>
            </div>
        </div>
    @endif

    <!-- Rata-rata per Pertanyaan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-4">Rata-rata Penilaian per Aspek</h4>
        <div class="space-y-4">
            @foreach($pertanyaanList as $pertanyaan)
                @php
                    $data = $rataPerPertanyaan[$pertanyaan->id] ?? ['rata_rata' => 0, 'jumlah' => 0];
                    $rata = $data['rata_rata'];
                    $jumlah = $data['jumlah'];
                    $persentase = $rata > 0 ? round(($rata / 5) * 100) : 0;
                    $warna = $rata >= 4.5 ? 'bg-emerald-500' : ($rata >= 4 ? 'bg-blue-500' : ($rata >= 3 ? 'bg-yellow-500' : ($rata >= 2 ? 'bg-orange-500' : 'bg-red-500')));
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <div>
                            <span class="text-sm font-medium text-navy">{{ $pertanyaan->kategori }}</span>
                            <span class="text-xs text-gray-400 ml-2">({{ $jumlah }} voting)</span>
                        </div>
                        <span class="text-sm font-bold {{ $rata < 3.5 ? 'text-red-600' : 'text-navy' }}">
                            {{ number_format($rata, 2) }}
                        </span>
                    </div>
                    <div class="w-full h-2.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full {{ $warna }} rounded-full transition-all duration-700" style="width: {{ $persentase }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $pertanyaan->pertanyaan }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Rekap Mahasiswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-4">Rekap Penilaian Mahasiswa</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-2 px-3 text-gray-500 font-medium">#</th>
                        <th class="text-left py-2 px-3 text-gray-500 font-medium">Nama Mahasiswa</th>
                        <th class="text-left py-2 px-3 text-gray-500 font-medium">NIM</th>
                        <th class="text-left py-2 px-3 text-gray-500 font-medium">Total Skor</th>
                        <th class="text-left py-2 px-3 text-gray-500 font-medium">Rata-rata</th>
                        <th class="text-left py-2 px-3 text-gray-500 font-medium">Tanggal</th>
                        <th class="text-left py-2 px-3 text-gray-500 font-medium">Kritik/Saran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapMahasiswa as $index => $item)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-2 px-3">{{ $index + 1 }}</td>
                        <td class="py-2 px-3 font-medium text-navy">{{ $item->nama }}</td>
                        <td class="py-2 px-3 text-xs">{{ $item->nim }}</td>
                        <td class="py-2 px-3">{{ $item->total_skor }}</td>
                        <td class="py-2 px-3">
                            <span class="font-bold {{ $item->rata_rata < 3 ? 'text-red-600' : 'text-navy' }}">
                                {{ number_format($item->rata_rata, 2) }}
                            </span>
                        </td>
                        <td class="py-2 px-3 text-xs">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="py-2 px-3 max-w-[150px]">
                            @if($item->kritik || $item->saran)
                                <button onclick="alert('Kritik: {{ $item->kritik ?? '-' }}\nSaran: {{ $item->saran ?? '-' }}')"
                                        class="text-xs text-gold hover:underline">
                                    Lihat
                                </button>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">Belum ada voting untuk dosen ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Export -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.analisis.export-pdf', $dosen->id) }}"
           class="px-6 py-2.5 bg-gold text-navy rounded-lg hover:bg-gold/90 transition font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export PDF
        </a>
        <a href="{{ route('admin.analisis.index') }}"
           class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
            Kembali
        </a>
    </div>
</div>
@endsection
