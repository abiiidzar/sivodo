<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ranking Dosen</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #1a2744; color: white; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #1a2744; margin: 0; }
        .header p { color: #6b7280; margin: 5px 0; }
        .footer { text-align: center; margin-top: 30px; color: #9ca3af; font-size: 10px; }
        .rank-1 { background: #c9a227; color: #1a2744; padding: 2px 8px; border-radius: 4px; }
        .rank-2 { background: #9ca3af; color: #1a2744; padding: 2px 8px; border-radius: 4px; }
        .rank-3 { background: #cd7f32; color: white; padding: 2px 8px; border-radius: 4px; }
        .bg-emerald { background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; }
        .bg-blue { background: #3b82f6; color: white; padding: 2px 8px; border-radius: 4px; }
        .bg-yellow { background: #f59e0b; color: white; padding: 2px 8px; border-radius: 4px; }
        .bg-orange { background: #f97316; color: white; padding: 2px 8px; border-radius: 4px; }
        .bg-red { background: #ef4444; color: white; padding: 2px 8px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RANKING DOSEN</h1>
        <p>SIVODO - Sistem Voting Dosen</p>
        <p>PT. Lentera Edukasi ENBI Nusantara</p>
        <p>Tanggal: {{ date('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Nama Dosen</th>
                <th>Program Studi</th>
                <th>Total Voting</th>
                <th>Rata-rata</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankingData as $item)
            <tr>
                <td>
                    <span class="rank-{{ $item->rank <= 3 ? $item->rank : 'default' }}">
                        {{ $item->rank }}
                    </span>
                </td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->program_studi }}</td>
                <td>{{ $item->total_voting }}</td>
                <td>{{ number_format($item->rata_rata, 2) }}</td>
                <td>
                    <span class="bg-{{
                        $item->kategori == 'Sangat Memuaskan' ? 'emerald' :
                        ($item->kategori == 'Memuaskan' ? 'blue' :
                        ($item->kategori == 'Puas' ? 'yellow' :
                        ($item->kategori == 'Cukup' ? 'orange' : 'red'))) }}">
                        {{ $item->kategori }}
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
