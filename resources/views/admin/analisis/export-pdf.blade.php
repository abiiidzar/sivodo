<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Analisis Dosen - {{ $dosen->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', 'Arial', sans-serif;
            padding: 30px 35px;
            font-size: 11px;
            line-height: 1.5;
            color: #1a2744;
        }

        /* HEADER */
        .header {
            text-align: center;
            border-bottom: 3px solid #1a2744;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .header .title {
            color: #1a2744;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .header .subtitle {
            color: #6b7280;
            font-size: 12px;
            margin-top: 3px;
        }
        .header .date {
            color: #9ca3af;
            font-size: 10px;
            margin-top: 2px;
        }

        /* INFO DOSEN */
        .info-box {
            background: #f5f3ef;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 18px;
            border-left: 4px solid #c9a227;
        }
        .info-box table { width: 100%; }
        .info-box td { padding: 3px 6px; font-size: 11px; }
        .info-box .label {
            font-weight: bold;
            color: #1a2744;
            width: 130px;
        }
        .info-box .value { font-weight: 600; }
        .info-box .highlight { color: #c9a227; font-size: 14px; }

        /* SECTION TITLE */
        .section-title {
            color: #1a2744;
            font-size: 14px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 8px;
            border-bottom: 2px solid #c9a227;
            padding-bottom: 4px;
        }

        /* TABEL */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 10px;
            font-size: 10px;
        }
        table th {
            background: #1a2744;
            color: white;
            padding: 5px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
        }
        table td {
            padding: 4px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
            vertical-align: middle;
        }
        table tr:nth-child(even) { background: #f9fafb; }
        table .text-center { text-align: center; }
        table .text-danger { color: #dc2626; font-weight: bold; }
        table .text-success { color: #16a34a; font-weight: bold; }
        table .text-gold { color: #c9a227; font-weight: bold; }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: 1px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }
        .bg-danger { background: #dc2626; }
        .bg-warning { background: #f59e0b; }
        .bg-success { background: #22c55e; }
        .bg-blue { background: #3b82f6; }
        .bg-orange { background: #f97316; }

        /* PROGRESS BAR */
        .bar-wrapper { display: flex; align-items: center; gap: 6px; }
        .bar-container {
            flex: 1;
            background: #e5e7eb;
            border-radius: 3px;
            height: 12px;
            overflow: hidden;
            min-width: 80px;
        }
        .bar-fill { height: 100%; border-radius: 3px; }
        .bar-text { font-size: 9px; min-width: 30px; font-weight: 600; }

        /* KELEMAHAN */
        .warning-box {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 10px;
        }
        .warning-box .title {
            color: #dc2626;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
        }

        /* RESPONSIVE */
        .page-break { page-break-before: always; }
        .mt-5 { margin-top: 5px; }
        .mb-5 { margin-bottom: 5px; }
        .mb-10 { margin-bottom: 10px; }
    </style>
</head>
<body>

    <!-- ==================== HEADER ==================== -->
    <div class="header">
        <div class="title">SIVODO</div>
        <div class="subtitle">Sistem Voting Kinerja Dosen - PT Lentera Edukasi ENBI Nusantara</div>
        <div class="date">Laporan Analisis Dosen | Dicetak: {{ date('d F Y H:i:s') }}</div>
    </div>

    <!-- ==================== INFORMASI DOSEN ==================== -->
    <div class="info-box">
        <table>
            <tr>
                <td class="label">Nama Dosen</td>
                <td class="value">{{ $dosen->nama }}</td>
                <td class="label" style="width:100px;">Total Voting</td>
                <td class="value text-center">{{ $totalVoting }} mahasiswa</td>
            </tr>
            <tr>
                <td class="label">NIDN</td>
                <td class="value">{{ $dosen->nidn }}</td>
                <td class="label">Rata-rata</td>
                <td class="value highlight">{{ number_format($rataRataKeseluruhan, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td class="value">{{ $dosen->program_studi }}</td>
                <td class="label">Status</td>
                <td>
                    @php
                        $status = $rataRataKeseluruhan >= 4.5 ? 'Sangat Baik' : ($rataRataKeseluruhan >= 4 ? 'Baik' : ($rataRataKeseluruhan >= 3 ? 'Cukup' : ($rataRataKeseluruhan >= 2 ? 'Kurang' : 'Sangat Kurang')));
                        $statusClass = $rataRataKeseluruhan >= 4.5 ? 'bg-success' : ($rataRataKeseluruhan >= 4 ? 'bg-blue' : ($rataRataKeseluruhan >= 3 ? 'bg-warning' : ($rataRataKeseluruhan >= 2 ? 'bg-orange' : 'bg-danger')));
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $status }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- ==================== KELEMAHAN ==================== -->
    @if(count($kelemahan) > 0)
        <div class="warning-box">
            <div class="title">⚠️ Aspek yang Perlu Diperhatikan (Rata-rata < 3.5)</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:30px;">No</th>
                        <th style="width:100px;">Kategori</th>
                        <th>Pertanyaan</th>
                        <th style="width:70px;">Rata-rata</th>
                        <th style="width:80px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelemahan as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item['pertanyaan']->kategori }}</td>
                        <td>{{ $item['pertanyaan']->pertanyaan }}</td>
                        <td class="text-center text-danger">{{ number_format($item['rata_rata'], 2) }}</td>
                        <td class="text-center"><span class="badge bg-danger">{{ $item['kategori']['label'] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- ==================== RATA-RATA PER PERTANYAAN ==================== -->
    <div class="section-title">📊 Rata-rata Penilaian per Aspek</div>
    <table>
        <thead>
            <tr>
                <th style="width:30px;">No</th>
                <th style="width:100px;">Kategori</th>
                <th>Pertanyaan</th>
                <th style="width:70px;">Rata-rata</th>
                <th style="width:150px;">Progress</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pertanyaanList as $index => $pertanyaan)
            @php
                $data = $rataPerPertanyaan[$pertanyaan->id] ?? ['rata_rata' => 0, 'jumlah' => 0];
                $rata = $data['rata_rata'];
                $persentase = $rata > 0 ? round(($rata / 5) * 100) : 0;
                $warna = $rata >= 4.5 ? '#22c55e' : ($rata >= 4 ? '#3b82f6' : ($rata >= 3 ? '#f59e0b' : ($rata >= 2 ? '#f97316' : '#dc2626')));
                $rataClass = $rata < 3.5 ? 'text-danger' : ($rata >= 4.5 ? 'text-success' : '');
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $pertanyaan->kategori }}</td>
                <td>{{ $pertanyaan->pertanyaan }}</td>
                <td class="text-center {{ $rataClass }}">{{ number_format($rata, 2) }}</td>
                <td>
                    <div class="bar-wrapper">
                        <div class="bar-container">
                            <div class="bar-fill" style="width: {{ $persentase }}%; background: {{ $warna }};"></div>
                        </div>
                        <span class="bar-text">{{ $persentase }}%</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ==================== REKAP MAHASISWA ==================== -->
    <div class="section-title">📋 Rekap Penilaian Mahasiswa</div>
    <table>
        <thead>
            <tr>
                <th style="width:30px;">No</th>
                <th style="width:120px;">Nama Mahasiswa</th>
                <th style="width:80px;">NIM</th>
                <th style="width:70px;">Total Skor</th>
                <th style="width:70px;">Rata-rata</th>
                <th style="width:100px;">Tanggal</th>
                <th>Kritik / Saran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapMahasiswa as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td class="text-center">{{ $item->nim }}</td>
                <td class="text-center">{{ $item->total_skor }}</td>
                <td class="text-center {{ $item->rata_rata < 3 ? 'text-danger' : ($item->rata_rata >= 4.5 ? 'text-success' : '') }}">
                    {{ number_format($item->rata_rata, 2) }}
                </td>
                <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                <td style="font-size:9px; max-width:150px;">
                    @if($item->kritik || $item->saran)
                        @if($item->kritik) K: {{ Str::limit($item->kritik, 30) }} @endif
                        @if($item->kritik && $item->saran) | @endif
                        @if($item->saran) S: {{ Str::limit($item->saran, 30) }} @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding:15px; color:#9ca3af;">Belum ada voting untuk dosen ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ==================== FOOTER ==================== -->
    <div class="footer">
        Laporan ini dihasilkan secara otomatis oleh SIVODO &bull; Data dapat berubah sewaktu-waktu
    </div>

</body>
</html>
