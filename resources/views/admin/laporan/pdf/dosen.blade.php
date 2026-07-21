<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dosen</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #1a2744; color: white; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #1a2744; margin: 0; }
        .header p { color: #6b7280; margin: 5px 0; }
        .footer { text-align: center; margin-top: 30px; color: #9ca3af; font-size: 10px; }
        .badge { padding: 2px 8px; border-radius: 4px; font-size: 10px; color: white; }
        .bg-emerald { background: #10b981; }
        .bg-blue { background: #3b82f6; }
        .bg-yellow { background: #f59e0b; }
        .bg-orange { background: #f97316; }
        .bg-red { background: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN EVALUASI DOSEN</h1>
        <p>SIVODO - Sistem Voting Dosen</p>
        <p>PT. Lentera Edukasi ENBI Nusantara</p>
        <p>Tanggal: {{ date('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dosen</th>
                <th>NIDN</th>
                <th>Program Studi</th>
                <th>Status</th>
                <th>Voting</th>
                <th>Rata-rata</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dosens as $index => $dosen)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $dosen->nama }}</td>
                <td>{{ $dosen->nidn }}</td>
                <td>{{ $dosen->program_studi }}</td>
                <td>{{ $dosen->status_dosen }}</td>
                <td>{{ $dosen->total_voting }}</td>
                <td>{{ number_format($dosen->rata_rata, 2) }}</td>
                <td>
                    <span class="badge
                        {{ $dosen->kategori == 'Sangat Memuaskan' ? 'bg-emerald' :
                           ($dosen->kategori == 'Memuaskan' ? 'bg-blue' :
                           ($dosen->kategori == 'Puas' ? 'bg-yellow' :
                           ($dosen->kategori == 'Cukup' ? 'bg-orange' : 'bg-red'))) }}">
                        {{ $dosen->kategori }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak dari SIVODO - {{ date('d M Y H:i:s') }}</p>
    </div>
</body>
</html>
