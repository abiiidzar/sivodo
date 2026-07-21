<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Program Studi</title>
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
        <h1>LAPORAN PROGRAM STUDI</h1>
        <p>SIVODO - Sistem Voting Dosen</p>
        <p>PT. Lentera Edukasi ENBI Nusantara</p>
        <p>Tanggal: {{ date('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Program Studi</th>
                <th>Total Dosen</th>
                <th>Dosen dengan Voting</th>
                <th>Total Voting</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->program_studi }}</td>
                <td>{{ $item->total_dosen }}</td>
                <td>{{ $item->dosen_with_voting }}</td>
                <td>{{ $item->total_voting }}</td>
                <td>{{ number_format($item->rata_rata, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak dari SIVODO - {{ date('d M Y H:i:s') }}</p>
    </div>
</body>
</html>
