<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Mata Kuliah</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #1a2744; color: white; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #1a2744; margin: 0; }
        .header p { color: #6b7280; margin: 5px 0; }
        .footer { text-align: center; margin-top: 30px; color: #9ca3af; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN MATA KULIAH</h1>
        <p>SIVODO - Sistem Voting Dosen</p>
        <p>PT. Lentera Edukasi ENBI Nusantara</p>
        <p>Tanggal: {{ date('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Semester</th>
                <th>Kelas</th>
                <th>Voting</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matakuliahs as $index => $mk)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mk->kode }}</td>
                <td>{{ $mk->nama }}</td>
                <td>{{ $mk->dosen->nama ?? '-' }}</td>
                <td>{{ $mk->semester }}</td>
                <td>{{ $mk->kelas ?? '-' }}</td>
                <td>{{ $mk->total_voting }}</td>
                <td>{{ number_format($mk->rata_rata, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak dari SIVODO - {{ date('d M Y H:i:s') }}</p>
    </div>
</body>
</html>
